<?php
if (php_sapi_name() !== 'cli') {
    exit('This script can only be run from the command line.');
}

require_once '../vendor/autoload.php';
require_once 'mailer.php';
use Symfony\Component\Mime\Email;

// Get the queue file path from command line argument
$queueFile = $argv[1] ?? null;
if (!$queueFile || !file_exists($queueFile)) {
    MailerConfig::getInstance()->log('ERROR', 'Invalid queue file: ' . ($queueFile ?? 'null'));
    exit('Invalid queue file.');
}

try {
    // Read email data
    $emailData = json_decode(file_get_contents($queueFile), true);
    if (!$emailData) {
        throw new Exception('Invalid email data');
    }
    
    $mailerConfig = MailerConfig::getInstance();
    
    // Check rate limits before sending
    if (!$mailerConfig->checkRateLimit()) {
        throw new Exception('Rate limit exceeded');
    }
    
    // Send email
    $email = (new Email())
        ->from($mailerConfig->getFromEmail())
        ->to($emailData['to'])
        ->subject($emailData['subject'])
        ->html($emailData['content']);
    
    $mailerConfig->getMailer()->send($email);
    
    // Update status and log success
    $emailData['status'] = 'sent';
    $emailData['sent_at'] = date('Y-m-d H:i:s');
    file_put_contents($queueFile, json_encode($emailData));
    $mailerConfig->log('INFO', sprintf('Email sent successfully to %s', $emailData['to']));
    
} catch (Exception $e) {
    // Log error and update status
    $mailerConfig = MailerConfig::getInstance();
    $mailerConfig->log('ERROR', sprintf('Failed to send email to %s: %s', $emailData['to'], $e->getMessage()));
    $emailData['status'] = 'failed';
    $emailData['error'] = $e->getMessage();
    file_put_contents($queueFile, json_encode($emailData));
}
?>