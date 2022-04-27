<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/Exception.php';
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';

  $mail = new PHPMailer(true);
  try {
      
      $mail->SMTPDebug = 0;                      
      $mail->isSMTP();                                 
      $mail->Host       = 'mail.aprendedordigital.org';   
      $mail->SMTPAuth   = true;                               
      $mail->Username   = 'info@aprendedordigital.org';             
      $mail->Password   = 'Inf0@2021$';                         
      $mail->SMTPSecure = 'ssl';          
      // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
      $mail->Port       = 465;                                    
      // if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      $mail->setFrom('info@aprendedordigital.org', '
      Informativo - Aprendedor Digital ');
      $mail->addAddress('rojasoscar85@gmail.com', 'Oscar Rojas');     //Add a recipient
     
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Correo de prueba';
      $mail->Body    = 'Probando envio de correo <b>Info!</b>';

      $mail->send();
      echo 'Mensaje enviado';
  } catch (Exception $e) {
      echo "Mailer Error: {$mail->ErrorInfo}";
  }
