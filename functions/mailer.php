<?php
require_once '../vendor/autoload.php';

use React\EventLoop\Loop;
use React\Promise\Promise;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use React\ChildProcess\Process;

class MailerConfig {
    private const GMAIL_USER = 'pio.iskolar.team@gmail.com';
    private const GMAIL_APP_PASSWORD = 'ixlrqofchjdhbbhj';
    private const FROM_EMAIL = 'Pio Iskolar <pio.iskolar.team@gmail.com>';
    private const QUEUE_DIR = __DIR__ . '/email_queue';
    private const LOG_DIR = __DIR__ . '/logs';
    
    // Gmail rate limits (per day: 2000, per second: ~2)
    private const RATE_LIMIT_PER_DAY = 2000;
    private const RATE_LIMIT_PER_SECOND = 2;
    private const RATE_LIMIT_FILE = self::QUEUE_DIR . '/rate_limit.json';
    
    private static $instance = null;
    private $mailer;
    
    private function __construct() {
        $dsn = sprintf('gmail://%s:%s@default', self::GMAIL_USER, self::GMAIL_APP_PASSWORD);
        $transport = Transport::fromDsn($dsn);
        $this->mailer = new Mailer($transport);
        
        // Create necessary directories
        foreach ([self::QUEUE_DIR, self::LOG_DIR] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
        
        // Initialize rate limit file if it doesn't exist
        if (!file_exists(self::RATE_LIMIT_FILE)) {
            $this->resetRateLimit();
        }
    }
    
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function resetRateLimit(): void {
        $rateLimit = [
            'daily_count' => 0,
            'daily_reset' => date('Y-m-d'),
            'last_sent' => microtime(true),
            'second_count' => 0
        ];
        file_put_contents(self::RATE_LIMIT_FILE, json_encode($rateLimit));
    }
    
    public function checkRateLimit(): bool {
        $rateLimit = json_decode(file_get_contents(self::RATE_LIMIT_FILE), true);
        
        // Reset daily count if it's a new day
        if ($rateLimit['daily_reset'] !== date('Y-m-d')) {
            $this->resetRateLimit();
            $rateLimit = json_decode(file_get_contents(self::RATE_LIMIT_FILE), true);
        }
        
        // Check daily limit
        if ($rateLimit['daily_count'] >= self::RATE_LIMIT_PER_DAY) {
            $this->log('ERROR', 'Daily email limit reached');
            return false;
        }
        
        // Check per-second limit
        $currentTime = microtime(true);
        if ($currentTime - $rateLimit['last_sent'] < 1) {
            if ($rateLimit['second_count'] >= self::RATE_LIMIT_PER_SECOND) {
                $this->log('WARNING', 'Rate limit reached, waiting...');
                sleep(1); // Wait for a second
                return $this->checkRateLimit(); // Recursive check
            }
        } else {
            $rateLimit['second_count'] = 0;
        }
        
        // Update rate limit data
        $rateLimit['daily_count']++;
        $rateLimit['last_sent'] = $currentTime;
        $rateLimit['second_count']++;
        file_put_contents(self::RATE_LIMIT_FILE, json_encode($rateLimit));
        
        return true;
    }
    
    public function log(string $level, string $message): void {
        $logFile = self::LOG_DIR . '/mailer_' . date('Y-m-d') . '.log';
        $logMessage = sprintf(
            '[%s] [%s] %s%s',
            date('Y-m-d H:i:s'),
            $level,
            $message,
            PHP_EOL
        );
        error_log($logMessage, 3, $logFile);
        
        // Also log to PHP error log for console visibility
        error_log($logMessage);
    }
    
    public function cleanupOldFiles(): void {
        // Clean up old log files (older than 7 days)
        $this->cleanupDirectory(self::LOG_DIR, '*.log', 7);
        
        // Clean up processed email files (older than 24 hours)
        $this->cleanupDirectory(self::QUEUE_DIR, '*.json', 1);
    }
    
    private function cleanupDirectory(string $dir, string $pattern, int $daysOld): void {
        $files = glob($dir . '/' . $pattern);
        $now = time();
        
        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= $daysOld * 86400) {
                    unlink($file);
                    $this->log('INFO', sprintf('Cleaned up old file: %s', basename($file)));
                }
            }
        }
    }
    
    public function getMailer(): Mailer {
        return $this->mailer;
    }
    
    public function getQueueDir(): string {
        return self::QUEUE_DIR;
    }
    
    public function getFromEmail(): string {
        return self::FROM_EMAIL;
    }
}

function queueEmail(string $to, string $subject, string $content): array {
    try {
        $mailerConfig = MailerConfig::getInstance();
        
        // Check rate limits before queuing
        if (!$mailerConfig->checkRateLimit()) {
            $mailerConfig->log('ERROR', sprintf('Rate limit exceeded for email to: %s', $to));
            return ['success' => false];
        }
        
        // Create email data
        $emailData = [
            'to' => $to,
            'subject' => $subject,
            'content' => $content,
            'timestamp' => date('Y-m-d H:i:s'),
            'status' => 'queued'
        ];
        
        // Generate unique filename and debug paths
        $filename = $mailerConfig->getQueueDir() . '/' . uniqid('email_') . '.json';
        $workerScript = __DIR__ . '/worker.php';
        
        // Debug logging
        error_log('Debug - Queue file path: ' . $filename);
        error_log('Debug - Worker script path: ' . $workerScript);
        error_log('Debug - Current directory: ' . getcwd());
        error_log('Debug - Script directory: ' . __DIR__);
        
        // Save email data to file
        file_put_contents($filename, json_encode($emailData));
        
        // Debug - Verify file exists
        error_log('Debug - Queue file exists: ' . (file_exists($filename) ? 'yes' : 'no'));
        
        // Start the background process with full paths
        $cmd = sprintf('php "%s" "%s" 2>&1', $workerScript, $filename);
        $output = [];
        $returnVar = -1;
        exec($cmd, $output, $returnVar);
        
        // Debug - Log command execution
        error_log('Debug - Command executed: ' . $cmd);
        error_log('Debug - Return value: ' . $returnVar);
        error_log('Debug - Command output: ' . print_r($output, true));
        
        return ['success' => true];
    } catch (\Exception $e) {
        error_log('Debug - Exception: ' . $e->getMessage());
        return ['success' => false];
    }
}

function queueBulkEmail(array $recipients, string $subject, string $content): array {
    try {
        $mailerConfig = MailerConfig::getInstance();
        $results = [];
        $successCount = 0;
        $failCount = 0;
        
        foreach ($recipients as $recipient) {
            $result = queueEmail($recipient, $subject, $content);
            if ($result['success']) {
                $successCount++;
            } else {
                $failCount++;
            }
            $results[$recipient] = $result;
        }
        
        $mailerConfig->log('INFO', sprintf('Bulk email queued: %d successful, %d failed', $successCount, $failCount));
        
        /* Original response preserved as comment
        return [
            'success' => true,
            'results' => $results,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        */
        return ['success' => true, 'queued' => $successCount, 'failed' => $failCount];
    } catch (\Exception $e) {
        $mailerConfig->log('ERROR', sprintf('Bulk email queueing failed: %s', $e->getMessage()));
        /* Original error response preserved as comment
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        */
        return ['success' => false];
    }
}
?>