<?php
// config/mail.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendNotification($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.smarttech.sn';             
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply@smarttech.sn'; 
        $mail->Password   = 'Sowi-2025';         
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    
        
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
                'allow_self_signed'=> true
            ]
        ];
    
        
        $mail->setFrom('noreply@smarttech.sn', 'Smarttech Notification');
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'e-mail : " . $mail->ErrorInfo);
        return false;
    }
}
?>
