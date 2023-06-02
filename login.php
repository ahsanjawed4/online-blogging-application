<?php
  session_start();
  require_once("./required/custom-functions.php");
  if(!isset($_SESSION["user"])){
    include_once("./includes/header.php");
    if(isset($_REQUEST["login"])) 
    error_modal("For Access You need to login first");
    elseif(isset($_REQUEST["required"]))
      error_modal("Kindly insert the data");
    elseif(isset($_REQUEST["invalid"]))
      error_modal("Invalid Credential Kindly insert correct information");
    elseif(isset($_REQUEST["is_pending"]))
    error_modal("Your Account Approval is in <span class='fs-4'>Pending</span>. kindly wait we'll inform you soon");
    elseif(isset($_REQUEST["is_rejected"])){
      error_modal("Your Account Approval is <span class='fs-4'>Rejected</span>. You are no longer to registered user now. you need to create new account with new email"); 
    }
    elseif(isset($_REQUEST["in_active"])){
      error_modal("Your Account Status is <span class='fs-4'>In Active </span> By Admin Due to some reason. Kindly wait for the email"); 
    }
    elseif (isset($_REQUEST["comments"])) 
      error_modal("For <span class='fs-4'>Posting Comments</span> You need to login first.");
    elseif(isset($_REQUEST["logout"])){
      error_modal("<span class='text-success'>Successfully logout</span>");
    }
    ?>
    <div class="container my-4">
      <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="login-container">
            <form class="form-horizontal" method="POST" action="./form.php">
              <h3 class="title">User Login</h3>
              <div class="form-group">
                <span class="input-icon"><i class="fa fa-user"></i></span>
                <input class="form-control" type="email" placeholder="Email Address" name="login_email"/>
              </div>
              <div class="form-group">
                <span class="input-icon"><i class="fa fa-lock"></i></span>
                <input class="form-control" type="password" placeholder="Password" name="login_password"/>
              </div>
              <input type="submit" class="btn signin" name="login_user" value="Login"/>
              <span class="forgot-pass">
                <a href="./forget-password.php" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Forgot Password?</a>
              </span>
              <span class="user-signup">
                Don't Have Account? <a href="./register.php">Signup</a>
              </span>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
    include_once("./includes/modals.php");
    forgetModal();
    include_once("./includes/footer.php");
	  custom_footer();
  } 
  else header("location:./index.php?user=true");

?>