<?php
  session_start();
  require_once("./required/database-class.php");
  require_once("./required/FPDF/fpdf.php");
  require_once("./required/pdf.php");
  require_once("./email.php");
  $users=$database->get_users();
  $role=$database->user_role();
  if(isset($_REQUEST["register_user"])){
    $flag=true;
    $error_msg=null;
    $fname_lname_pattern = "/^[A-Z a-z 0-9]{3,}$/";
    $email_pattern = "/^[A-Z a-z 0-9]{2,}[@][a-z]{5,}[.][a-z]{2,}$/";
    $password_pattern = "/^[A-Z a-z 0-9]{8,}$/";
    $dob_pattern="/^[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}$/";
    if($_REQUEST["fname"]){
      if(!preg_match($fname_lname_pattern,$_REQUEST["fname"])){
        $error_msg.="first name contain atleast 3 characters long<br/>";
        $flag=false;
      }
    }
    else {
      $error_msg.="first name is required <br/>";
      $flag=false;
    }
    if($_REQUEST["lname"]){
      if(!preg_match($fname_lname_pattern,$_REQUEST["lname"])){
        $error_msg.="last name contain atleast 3 characters long<br/>";
        $flag=false;
      }
    }
    else {
      $error_msg.="last name is required <br/>";
      $flag=false;
    }
    if($_REQUEST["email"]){
      if(!preg_match($email_pattern,$_REQUEST["email"])){
        $error_msg.="email like:abc@gmail.com<br/>";
        $flag=false;
      }
    }else{
      $error_msg.="email is required <br/>";
      $flag=false;
    }
    if($_REQUEST["confirm_email"]){
      if($_REQUEST["confirm_email"]!=$_REQUEST["email"]){
        $error_msg.="confirmation email is not matched<br/>";
        $flag=false;
      }
    }else {
      $error_msg.="confirmation email is required <br/>";
      $flag=false;
    }
    if($_REQUEST["password"]){
      if(!preg_match($password_pattern,$_REQUEST["password"])){
        $error_msg.="password atleast 8 characters long<br/>";
        $flag=false;
      }
    }
    else {
      $error_msg.="password is required <br/>";
      $flag=false;
    }
    if($_REQUEST["confirm_password"]){
      if($_REQUEST["confirm_password"]!=$_REQUEST["password"]){
        $error_msg.="confirmation password is not matched<br/>";
        $flag=false;
      }
    }else {
      $error_msg.="confirmation password is required <br/>";
      $flag=false; 
    }
    if($_FILES["profile_image"]["name"]){
      $img_extensions=["jpeg","png","gif","tiff","jpg","psd","JPEG","PNG","GIF","TIFF","JPG","PSD"];
      $path=pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION);
      $all_extensions="";
      $valid_extension=false;
      foreach($img_extensions as $key=>$extensions){
        if($key==sizeof($img_extensions)-1) $all_extensions.=$extensions;
        else $all_extensions.="$extensions, ";
        if($extensions==$path)$valid_extension=true;
      }
      if(!$valid_extension){
        $error_msg.="File type of <b>".$_FILES["profile_image"]["name"] ."</b> must be a  <b>[ " .$all_extensions." ]</b><br/>";
        $flag=false;
      }
      if($_FILES["profile_image"]["size"]>1000000){
        $error_msg.="Max size of image is <b>1MB</b><br/>";
        $flag=false;
      }
    }else {
      $error_msg.="upload image is required <br/>";
      $flag=false; 
    }
    if($_REQUEST["date_of_birth"]){
      if(!preg_match($dob_pattern,$_REQUEST["date_of_birth"])){
        $error_msg.="Invalid Date of Birth i.e:2001-0-26";
        $flag=false;
      }
    }
    else {
      $error_msg.="Date of Birth is required<br/>";
      $flag=false;
    }
    if(!isset($_REQUEST["gender"])){
      $error_msg.="gender is required <br/>";
      $flag=false;
    }
    if(!$_REQUEST["address"]){
      $error_msg.="address is required<br/>";
      $flag=false;
    }
    if($flag){
      $tmp_name=$_FILES["profile_image"]["tmp_name"];
      $img_name=$_FILES["profile_image"]["name"];
      $destination=rand()."_".$img_name;
        $insert=true;
        while($user_record=mysqli_fetch_object($users))
          if($user_record->email===$_REQUEST["email"]) $insert=false;
        if($insert){
          $registered=$database->register_user(2,$_REQUEST["fname"],$_REQUEST["lname"],$_REQUEST["email"],$_REQUEST["password"],$_REQUEST["gender"],$_REQUEST["date_of_birth"],$destination,$_REQUEST["address"],"Pending","InActive");
          if($registered){
            move_uploaded_file($tmp_name,"./assets/images/users/".$destination);
            $date=explode("-",$_REQUEST["date_of_birth"]);
            $months=["January","February","March","April","May","June","July","August","September","October","November","December"];
            $date=$date[2]."-".$months[$date[1]-1] ."-".$date[0];
            pdf_generator($_REQUEST["fname"],$_REQUEST["lname"],$_REQUEST["email"],$_REQUEST["password"],$date,$_REQUEST["gender"],$_REQUEST["address"]);
            // EmailSent($_REQUEST["email"],"Account Creation","Your Account is Created your email is ".$_REQUEST["email"]." and your password is ".$_REQUEST["password"]." And Your Status is <span style='color:green'>Pending </span>.Kindly Wait. You will recieve email soon.");
            // header("location:./register.php?email=true");
          }
        }
        else header("location:./register.php?invalid=true");
        setcookie("registration_error",base64_encode($error_msg),time()-10);
    }
    else {
      setcookie("registration_error",base64_encode($error_msg));
      header("location:./register.php?error=true");
    }
  }
  // login user
  elseif(isset($_REQUEST["login_user"])){
    $flag=true;
    if(!$_REQUEST["login_email"] OR !$_REQUEST["login_password"])
      $flag=false;
    if($flag){
      $valid=false;
      while($data=mysqli_fetch_object($role)){
        if($data->email===$_REQUEST["login_email"] AND $data->password===$_REQUEST["login_password"]){
          $valid=true;
          $record=$data;
        }
      }
      if($valid) {
        if($record->is_approved==="Pending")
          header("location:./login.php?is_pending=true");
        elseif($record->is_approved==="Rejected")
          header("location:./login.php?is_rejected=true");
        elseif($record->is_approved==="Approved"){
          if($record->is_active==="Active"){
            settype($record->role_id,"integer");
            $_SESSION["user"]=$record;
            if($record->role_id===1) header("location:./admin.php");
            elseif($record->role_id===2) header("location:./user.php");
          } else header("location:./login.php?in_active=true");
        }
      } else header("location:./login.php?invalid=true");
    } else header("location:./login.php?required=true");
  }
?>