<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ReservationMail
{
    public PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['MAIL_HOST'];
        $this->mail->Port       = (int) $_ENV['MAIL_PORT'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['MAIL_USERNAME'];
        $this->mail->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $this->mail->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );

        $this->mail->CharSet  = 'UTF-8';
        $this->mail->Encoding = PHPMailer::ENCODING_BASE64;
        $this->mail->isHTML(true);
    }

    public function sendConfirmationCode($email, $code): bool
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($email);
            $this->mail->Subject = 'Système réservation - Restaurant';
            $this->mail->Body    = "Votre réservation est confirmée.<br><b>Code : $code</b>";

            return $this->mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
