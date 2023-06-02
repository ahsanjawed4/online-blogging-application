<?php
	session_start();
	if(isset($_SESSION["user"])){
		include_once("./includes/header.php");
		?>
			<h1>Gallery</h1>
		<?php
		include_once("./includes/footer.php");
		custom_footer();
	}else {
		header("location:./login.php?login=true");
	}
?>