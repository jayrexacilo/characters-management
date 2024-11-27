<?php

use CodeIgniter\Config\Services;

/**
 * Sends an email.
 *
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $message Email message (HTML format supported)
 * @param string|null $from Sender email address (optional, defaults to email.SMTPUser in .env)
 * @param string|null $fromName Sender name (optional, defaults to "Your App Name")
 *
 * @return bool|string True if sent successfully, otherwise error message
 */
function sendEmail(string $to, string $subject, string $message, string $from = null, string $fromName = null)
{
    $email = Services::email();

    // Set sender's email and name
    $from = $from ?? getenv('email.SMTPUser'); // Default to .env sender
    $fromName = $fromName ?? 'Whitetower test'; // Change to your app's name

    $email->setFrom($from, $fromName);
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($message);

    // Try to send the email and log the result
    if ($email->send()) {
        $logMessage = "123Email sent successfully to {$to}";
        log_message('info', $logMessage);

        // Print success to the command line
        if (is_cli()) {
            echo $logMessage . PHP_EOL;
        }
        return true;
    } else {
        $logMessage = "123Failed to send email to {$to}. Error: " . $email->printDebugger(['headers']);
        log_message('error', $logMessage);

        // Print failure to the command line
        if (is_cli()) {
            echo $logMessage . PHP_EOL;
        }
        return false;
    }
}
