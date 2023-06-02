<?php
	session_start();
	require_once("./required/database-class.php");
  require_once("./required/custom-functions.php");
	include_once("./includes/header.php");
	if(isset($_REQUEST["feedback_submit"])){
		$flag=true;
		extract($_REQUEST);
		if(!$feedback_fname OR !$feedback_lname OR
		!$feedback_email OR !$feedback_comment)
		$flag=false;
		$user_id=null;
		if($flag){
			if(isset($_SESSION["user"])){$user_id=$_SESSION["user"]->user_id;}
			$fullname=$feedback_fname ." " .$feedback_lname;
			$insert=$database->insert_feedback($user_id,$fullname,$feedback_email,$feedback_comment);
			if($insert) header("location:./feedback.php?feedback=true");
		}
	}
	if(isset($_REQUEST["feedback"]))error_modal("<span class='text-primary'>Thank You For Your Feedback:-</span>");
	?>
		<div class="container contact">
			<div class="row d-flex justify-content-center">
				<div class="col-md-3 contact-msg">
					<div class="contact-info">
						<img src="https://image.ibb.co/kUASdV/contact-image.png" alt="image"/>
						<h2>Contact Us</h2>
						<h4>We would love to hear from you !</h4>
					</div>
				</div>
				<div class="col-md-9">
					<div class="contact-form">
						<form action="#" method="POST">
							<div class="form-group">
								<?php
									if(!isset($_SESSION["user"])){
										?>
										<label class="control-label col-sm-2" for="fname">First Name:</label>
										<?php
									}
								?>
								<div class="col-sm-10">          
								<input type="<?php echo isset($_SESSION["user"]) ? "hidden" : "text" ?>" class="form-control" placeholder="Enter First Name" name="feedback_fname" value="<?php echo isset($_SESSION["user"]) ? $_SESSION["user"]->first_name : "" ?>"/>
								</div>
							</div>
							<div class="form-group">
								<?php
									if(!isset($_SESSION["user"])){
										?>
										<label class="control-label col-sm-2" for="lname">Last Name:
										</label>
										<?php
									}
								?>
									<div class="col-sm-10">          
									<input type="<?php echo isset($_SESSION["user"]) ? "hidden" : "text" ?>" class="form-control"  placeholder="Enter Last Name" name="feedback_lname" value="<?php echo isset($_SESSION["user"]) ? $_SESSION["user"]->last_name : "" ?>"/>
									</div>
							</div>
							<div class="form-group">
								<?php
									if(!isset($_SESSION["user"])){
										?>
										<label class="control-label col-sm-2" for="email">Email:
										</label>
										<?php
									}
								?>
								<div class="col-sm-10">
									<input type="<?php echo isset($_SESSION["user"]) ? "hidden" : "email" ?>" class="form-control"  placeholder="Enter email" name="feedback_email" value="<?php echo isset($_SESSION["user"]) ? $_SESSION["user"]->email : "" ?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">Feedback:</label>
								<div class="col-sm-10">
								<textarea class="form-control" rows="5" name="feedback_comment"></textarea>
								</div>
							</div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 mt-2">
								<input type="submit" value="Submit" name="feedback_submit" class="btn btn-default"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
  <?php
	include_once("./includes/footer.php");
	custom_footer();
?>