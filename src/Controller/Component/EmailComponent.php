<?php

namespace Cake\Controller\Component;

use Cake\Controller\Component;
use Exception;

class EmailComponent extends Component
{
    public function send($to, $subject, $message, $cc = null)
    {
        $sender     = "infobookanartiste@gmail.com";
        $senderName = "Book An Artiste";

        $usernameSmtp = "rupam@doomshell.com";
        $passwordSmtp = "fsahzjukbztivrtg"; // Gmail app password

        $host = "smtp.gmail.com";
        $port = 465;

        $mail = new \PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $usernameSmtp;
            $mail->Password   = $passwordSmtp;
            $mail->Port       = $port;
            $mail->SMTPSecure = 'ssl';

            // Sender
            $mail->setFrom($sender, $senderName);

            // Recipient
            $mail->addAddress($to);

            if (!empty($cc)) {
                $mail->addCC($cc);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            // Send mail
            $mail->send();

            return [
                'success' => true,
                'message' => 'Mail sent successfully'
            ];
        } catch (\phpmailerException $e) {

            return [
                'success' => false,
                'error'   => $mail->ErrorInfo
            ];
        } catch (Exception $e) {

            return [
                'success' => false,
                'error'   => $e->getMessage()
            ];
        }
    }
}
