<?php
include '../resources/phpmailer/PHPMailer.php';
include '../resources/phpmailer/SMTP.php';
include '../resources/phpmailer/Exception.php';


function welcomeMail($to) {
  $subject = 'Welcome';
  $message = 'hello';
  return sendMail($to, $subject, $message);
}

function orderMail($to, $message) {
  return sendMail($to, "Purchase order", $message);
}

function sendMail($to, $subject, $message) {
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $mail->PluginDir ='../resources/phpmailer';
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
  $mail->FromName = 'Rudygoal';
  $mail->addAddress($to, "u1");
  $mail->Subject = $subject;
  $mail->Body = $message;
  if (!$mail->Send())
    return false;
  else
    return true;
}
 ?>
