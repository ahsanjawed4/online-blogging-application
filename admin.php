<?php
session_start();
if(isset($_SESSION["user"])){
	if($_SESSION["user"]->role_id===2) header("location:./user.php");
	else {
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<title>Online Blogging Application</title>
			<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap"rel="stylesheet"/>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"/>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
			<link rel="stylesheet" href="./assets/css/style.css">
		</head>
		<body>
			<div class="container-fluid sidebar-container">
				<div class="row flex-nowrap sidebar-row">
					<?php include_once("./includes/sidebar.php") ?>
					<div class="col py-3">
						<center><button class="btn btn-primary d-sm-none b-block px-2 fs-2 fw-bold" onclick="logout()">Logout</button></center>
						<h1 class="admin-heading text-center"> 
							Welcome <?php echo $_SESSION["user"]->email ?>
						</h1>
						<div class="contatainer my-2">
							<div class="row d-flex justify-content-center" id="view_user"></div>
						</div>
						<div  id="manage_admin">
							<div class="panel">
								<div class="panel-heading">
									<div class="row">
										<div class="col col-sm-9 col-xs-12">
											<h4 class="admin-heading mt-2 fw-bold" id="reg_user">Registered Users</h4>
										</div>
										<div class="col-sm-3 col-xs-12 text-right">
											<div class="search-box">
												<input
												type="text"
												class="form-control py-2"
												placeholder="Search here"
												id="filter_Value"
												onkeyup="filtering()"
												/>
											</div>
										</div>
									</div>
								</div>
								<div class="row mb-2 d-flex justify-content-lg-between justify-content-center">
									<div class="col-lg-6">
										<button class="btn fw-bold btn-sm btn-success text-light" onclick="account_approval(this)" value="Approved">Approved Users</button>
										<button class="btn fw-bold btn-sm btn-danger text-light"
										onclick="account_approval(this)" value="Rejected">Rejected Users</button>
										<button class="btn fw-bold btn-sm btn-warning text-dark"
										onclick="account_approval(this)" value="Pending">Pending Users</button>
									</div>
									<div class="col-lg-5">
										<p class="text-muted mt-2"><b>Note</b>:You can't edit 
										<b class="text-danger">Rejected</b> user and <b class="text-success">Admin</b> you can only just view.</p>
									</div>
								</div>
								<div class="col-12">
									<button class="btn btn-outline-light fw-bold mb-2" onclick="add_user()" id="add">Add User</button>
								</div>
								<div id="user_table"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			include_once("./includes/footer.php");
			custom_footer("user");
	}
}
else header("location:./login.php?login=true");
	?>