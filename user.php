<?php
session_start();
if(isset($_SESSION["user"])){
	require_once("./required/database-class.php");
	if($_SESSION["user"]->role_id===1) header("location:./admin.php");
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
							<div class="row d-flex justify-content-center" id="view_user">
								<?php
									$users=$database->get_users();
									$data=null;
									while($user=mysqli_fetch_object($users)){
										if($user->user_id==$_SESSION["user"]->user_id) $data=$user;
									}
								?>
								<div class="col-md-4">
									<img alt="" class="img-circle img-thumbnail" 
										src="./assets/images/users/<?php echo $data->user_image ?>" style="width:500px;height:420px"/>
								</div>
								<div class="col-md-6">
								<div class="table-responsive">
									<table class="table table-user-information" id="table_data">
										<tbody>
											<tr>
												<td><h5>Full Name</h5></td>
												<td><?php echo ucwords($data->first_name ." " .$data->last_name) ?></td>
											</tr>
											<tr>
												<td><h5>Email</h5></td>
												<td><?php echo $data->email ?></td>
											</tr>
											<tr>
												<td><h5>Password</h5></td>
												<td><?php echo $data->password ?></td>
											</tr>
											<tr>
												<td><h5>Gender</h5></td>
												<td><?php echo $data->gender ?></td>
											</tr>
											<tr>
												<td><h5>Date Of Birdh</h5></td>
												<td><?php echo $data->date_of_birth ?></td>
											</tr>
											<tr>
												<td><h5>Account</h5></td>
												<td>
													<?php echo $data->role_id=="1" ?
													"<span class='btn btn-sm btn-success fw-bold'>Admin</span>" :
													"<span class='btn btn-sm btn-warning fw-bold'>User</span>" ?>
												</td>
											</tr>
											<tr>
												<td>
													<h5>Approval</h5>
												</td>
												<td><?php echo $data->is_approved ?></td>
											</tr>
											<tr>
												<td><h5>Active Status</h5></td>
												<td><?php echo $data->is_active ?></td>
											</tr>
											<tr>
												<td><h5>Address</h5></td>
												<td><?php echo $data->address ?></td>
											</tr>
											<tr>
												<td><h5>Created At:</h5></td>
												<td><?php echo $data->created_at ?></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			include_once("./includes/footer.php");
			custom_footer("account");	
		}
	}else header("location:./login.php?login=true");
	?>