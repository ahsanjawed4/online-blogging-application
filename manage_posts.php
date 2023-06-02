	<?php
	session_start();
	if(isset($_SESSION["user"])){
		if($_SESSION["user"]->role_id=="1"){
			?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<title>Online Blogging Application</title>
				<link
				href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap"
				rel="stylesheet"
				/>
				<link
				href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
				rel="stylesheet"
				/>
				<link
				rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
				/>
				<link rel="stylesheet" href="./assets/css/style.css" />
			</head>
			<body>
				<div class="container-fluid sidebar-container">
					<div class="row flex-nowrap sidebar-row">
						<?php include_once("./includes/sidebar.php") ?>
						<div class="col py-3">
							<center>
								<button
								class="btn btn-primary btn-sm d-sm-none b-block  fs-2 fw-bold"
								onclick="logout()"
								>
								Logout
							</button>
						</center>
						<h1 class="admin-heading text-center">
							Welcome <?php echo $_SESSION["user"]->email ?>
						</h1>
						<div class="contatainer my-2">
							<div class="row d-flex justify-content-center" id="view_user">
							</div>
						</div>
						<div class="container" id="manage_posts">
							<div class="row d-flex justify-content-center" id="manage_posts_row">
								<div class="col-md-8" id="manage_posts_col"></div>
							</div>
							<div class="col-12">
								 <div class="col-lg-6 col-10 order-lg-1 order-0">
                      				<p class="text-muted mt-2"><b>Note</b>:You can edit <b class="text-success">those Posts</b> which is created By You.<br/> and can't view <span class="text-danger fw-bold">InActive</span> Blogs.
                      				</p>
                    			</div>
								<h1>Posts</h1>
							</div>
							<div class="col-12 my-4" id="post_table"></div>
						</div>
					</div>
				</div>
			</div>
			<?php
			include_once("./includes/footer.php");
            custom_footer("posts");	
		}else header("location:./user.php");
	}else header("location:./login.php?login=true");
	?>