<?php
  session_start();
  session_destroy();
  // unset($_SESSION["user"]->approved_status);
  // setcookie("approved_status","",time()-1);
  header("location:./login.php?logout=true");
//   require_once('PHPMailer/src/PHPMailer.php');
// require 'PHPMailer/src/SMTP.php';

// require 'PHPMailer/src/Exception.php';

// $mail = new PHPMailer();

// $mail->isSMTP();

// $mail->Host = 'smtp.gmail.com';

// $mail->Port = 587;


// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

// $mail->SMTPAuth = true;



// $mail->Username = 'ahsanjawed16412@gmail.com';




// $mail->Password = 'wlbnliipowariasj';


// $mail->setFrom('ahsanjawed16412@gmail.com', 'MY ACTION');


// $mail->addAddress($email, 'MY ACTION');

// $mail->Subject = "ACCOUNT ACTIVITY";

// $mail->msgHTML(" DEAR CUSTOMER ".$firstname." ".$lastname." YOUR ACCOUNT IS IN PENDING STATE WAIT TILL ADMIN APPROVE IT YOU WILL GET A EMAIL AS SOON AS ANY ACTION IS TAKEN BY ADMIN  TO GET FURTHER DETAILS KINDLY CONTACT US THANKYOU ");

// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;


// } else {
//     $msg ='<h1 style="color:green;">Message sent!</h1>';

   
// }
?>