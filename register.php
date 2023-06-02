<?php
  session_start();
  require_once("./required/custom-functions.php");
  if(!isset($_SESSION["user"])){
    include_once("./includes/header.php");
      if(isset($_REQUEST["error"])) {
        error_modal(isset($_COOKIE["registration_error"]) ? base64_decode($_COOKIE["registration_error"]):"");
      }
      elseif(isset($_REQUEST["invalid"])) 
        error_modal("Email is already registered");
      // elseif(isset($_REQUEST["email"])){
      //   error_modal("<span style='color:green'>Thank You For Registration. Kindly check Email</span>");
      // } 
    ?>
    <div class="container my-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-lg-6">
          <?php include_once("./includes/register-users.php") ?>
        </div>
      </div>
    </div>
    <?php
    include_once("./includes/footer.php");
    custom_footer("regiseter");
  } else header("location:./index.php?user=true");
?>