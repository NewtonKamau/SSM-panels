<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mail {

  public function send($email, $name, $subject, $htmlmessage) {

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'elmehdi.elboukili@gmail.com';
        $mail->Password = 'N0TH1ngh3r3@';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        //Recipients
        $mail->setFrom('noreply@coinhuis.com', 'Notification');
        $mail->addAddress($email, $name);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $htmlmessage;
        $mail->AltBody = strip_tags(str_replace("<br>", "\n", $htmlmessage));

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }

  }
}

?>
