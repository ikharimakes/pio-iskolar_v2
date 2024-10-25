<?php
// send_email.php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Include the Composer autoloader (assuming it's in the parent directory)
require_once '../vendor/autoload.php';

// Retrieve the passed arguments
$recipientsString = $argv[1]; // Recipients as a comma-separated string
$subject = $argv[2];
$message = $argv[3];
$from = $argv[4];

// Convert the recipients string back into an array
$recipients = explode(',', $recipientsString);

// Configure the mailer with Gmail
// $dsn = 'gmail://raisseille@gmail.com:odaqgskzkeohvnwu@default';
$dsn = 'gmail://pio.iskolar.team@gmail.com:pogvqxmkzfyxnqt@default';
$transport = Transport::fromDsn($dsn);
$mailer = new Mailer($transport);

// Loop through recipients and send email to each
foreach ($recipients as $recipient) {
    // Create the email
    $email = (new Email())
        ->from($from)
        ->to(trim($recipient)) // Trim any whitespace
        ->subject($subject)
        ->html($message); // HTML content of the message

    // Send the email
    $mailer->send($email);

    echo "Email sent to: $recipient\n"; // Log the successful sending of an email
}
