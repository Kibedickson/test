<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->Host = 'host';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = 'username';
        $this->mail->Password = 'password';
    }

    public function send(array $contents): void
    {
        try {
            $this->mail->setFrom('test@email.com', 'John Doe');
            $this->mail->addAddress($contents['email'], $contents['name']);

            $this->mail->isHTML(true);
            $this->mail->Subject = $contents['subject'];
            $this->mail->Body = $contents['body'];
            $this->mail->send();
        } catch (Exception $e) {
            echo "Error sending email: {$e->errorMessage()}";
        }
    }
}