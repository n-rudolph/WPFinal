<?php
include '../resources/phpmailer/PHPMailer.php';
include '../resources/phpmailer/SMTP.php';
include '../resources/phpmailer/Exception.php';

function welcomeMail($to)
{
    $subject = 'Welcome';
    $message = 'hello';

    return sendMail($to, $message, $subject);
}

function orderMail($to, $message)
{
    sendMail($to, $message, "Purchase in Rudygoal");
}

function sendMail($to, $message, $subject) {
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $mail->PluginDir = '../resources/phpmailer'; // relative path to the folder where PHPMailer's files are located
  $mail->IsSMTP();
  $mail->Port = 465;
  $mail->Host = 'smtp.gmail.com';
  $mail->IsHTML(true); // if you are going to send HTML formatted emails
  $mail->Mailer = 'smtp';
  $mail->SMTPSecure = 'ssl';

  $mail->SMTPAuth = true;
  // $mail->Username = "nicolas.rudolph2@gmail.com";
  // $mail->Password = "nicochero21";
  $mail->Username = "rudygoal.info@gmail.com";
  $mail->Password = "1q3e4r2w";

  $mail->From = "rudygoal.info@gmail.com";
  $mail->FromName = "Rudygoal";

  $mail->addAddress("nicolas.rudolph@ing.austral.edu.ar","User 1");

  $mail->Subject = $subject;
  $mail->Body = $message;

  if(!$mail->Send())
      return false;
  else
      return true;

}
