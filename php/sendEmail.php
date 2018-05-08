<?php

//  require_once("../resources/php-mailer/PHPMailer2.php");
//  $mail = new PHPMailer();
//
//  //Luego tenemos que iniciar la validación por SMTP:
//  $mail->IsSMTP();
//  $mail->SMTPAuth = true;
//  $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
//  $mail->Username = "nicolas.rudolph2@gmail.com";
//  $mail->Password = "nicochero21"; // Contraseña
//  $mail->Port = 25; // Puerto a utilizar
//
//  //Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
//  $mail->From = "info@elserver.com"; // Desde donde enviamos (Para mostrar)
//  $mail->FromName = "Nombre";
//
//  //Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
//  $mail->AddAddress("correo"); // Esta es la dirección a donde enviamos
//  $mail->IsHTML(true); // El correo se envía como HTML
//  $mail->Subject = "Titulo"; // Este es el titulo del email.
//  $body = "Hola mundo Esta es la primer línea";
//  $body .= "pepe";
//  $mail->Body = $body; // Mensaje a enviar
//  $exito = $mail->Send(); // Envía el correo.
//
//  //También podríamos agregar simples verificaciones para saber si se envió:
//  if($exito){
//  echo "El correo fue enviado correctamente.";
//  }else{
//  echo "Hubo un inconveniente. Contacta a un administrador.";
//  }

function welcomeMail($to)
{
    $subject = 'Welcome';
    $message = 'hello';
    $headers = 'From: best@gmail.com' . "\r\n" .
        'Reply-To: best@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
}

function orderMail($to, $message)
{
    $subject = 'Order confirmed';
    $headers = 'From: best@myapp.com' . "\r\n" .
        'Reply-To: best@myapp.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
    return true;
}