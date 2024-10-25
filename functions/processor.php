<?php
// processor.php
require_once 'mailer.php';

if (php_sapi_name() !== 'cli') {
    exit('This script can only be run from the command line.');
}

// Get arguments
$email = $argv[1] ?? null;
$encodedSubject = $argv[2] ?? null;
$encodedContent = $argv[3] ?? null;

if (!$email || !$encodedSubject || !$encodedContent) {
    error_log("[EMAIL-PROCESSOR] Missing required arguments");
    exit(1);
}

// Decode the subject and content
$subject = base64_decode($encodedSubject);
$content = base64_decode($encodedContent);

// Log start of process
error_log("[EMAIL-PROCESSOR] Starting email process for: " . $email);

// Queue the email
$result = queueEmail($email, $subject, $content);

// Log result
error_log("[EMAIL-PROCESSOR] Email process complete for {$email}: " . json_encode($result));
?>