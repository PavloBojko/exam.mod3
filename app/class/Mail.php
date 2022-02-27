<?php

namespace App\Clas;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;
    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
    }
    public function login_mail($mail, $selector, $token)
    {
        try {
            //Server settings
            // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = 'pavlobojko80@gmail.com';                     //SMTP username
            $this->mail->Password   = '1980pacha';                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('pavlobojko80@gmail.com', 'Mailer');
            $this->mail->addAddress($mail, 'Pavel Boiko');     //Add a recipient
            // $this->mail->addAddress('ellen@example.com');               //Name is optional
            // $this->mail->addReplyTo('info@example.com', 'Information');
            // $this->mail->addCC('cc@example.com');
            // $this->mail->addBCC('bcc@example.com');

            // //Attachments
            // $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Here is the subject';
            $this->mail->Body    = "<a href='https://exam.mod3/verificationmail?selector={$selector}&token={$token}'>для подтверждения почты перейдите по ссылке</a>";
            $this->mail->AltBody = "<a href='https://exam.mod3/login?selector={$selector}&token={$token}'>для подтверждения почты перейдите по ссылке</a>";

            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";die;
        }
    }
}
