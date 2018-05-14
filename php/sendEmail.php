<?php
include '../resources/phpmailer/PHPMailer.php';
include '../resources/phpmailer/SMTP.php';
include '../resources/phpmailer/Exception.php';


function welcomeMail($to)
{
    $subject = 'Welcome to Rudygol!';
    $message = "<h2>Dear customer: </h2><br><br><h4>We are pleased to welcome you to the Rudygol community. ";
    $message.= "We hope you have a great time with us. Please, contact us if you have any question. <h4><br><br>";
    $message.= "<h3>The Rudygol team</h3>";
    return sendMail($to, $subject, $message);
}

function orderMail($to, $message)
{
    return sendMail($to, "Order Confirmation - Rudygol", $message);
}

function sendMail($to, $subject, $message)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->PluginDir = '../resources/phpmailer';
    $mail->IsSMTP();
    $mail->Port = 465;
    $mail->Host = 'smtp.gmail.com';
    $mail->IsHTML(true);
    $mail->Mailer = 'smtp';
    $mail->SMTPSecure = 'ssl';

    $mail->SMTPAuth = true;
    $mail->Username = 'rudygoal.info@gmail.com';
    $mail->Password = '1q3e4r2w';

    $mail->From = 'rudygoal.info@gmail.com';
    $mail->FromName = 'Rudygol';
    $mail->addAddress($to, "u1");
    $mail->Subject = $subject;
    $mail->Body = $message;
    if (!$mail->Send())
        return false;
    else
        return true;
}

?>
