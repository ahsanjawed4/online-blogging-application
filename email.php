<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/Exception.php');
function EmailSent($reciever,$subject,$msg,$sender="ahsanjawed16412@gmail.com"){
  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->SMTPAuth = true;
  $mail->Username = $sender;
  $mail->Password = 'wlbnliipowariasj';
  $mail->setFrom($sender, "Online Blogging Application");
  $mail->addAddress($reciever, substr($reciever,0,strpos($reciever, "@")));
  $mail->Subject = "$subject";
  $mail->msgHTML("<h2 color:'#000'>$msg</h2>");
  if (!$mail->send())echo 'Mailer Error: ' . $mail->ErrorInfo;
  else echo '<h1 style="color:green;">Message sent!</h1>'; 
}
 /*
 two-step-password:wlbnliipowariasj
 email:ahsanjawed16412@gmail.com
 password:ahsan16412

*/
?>