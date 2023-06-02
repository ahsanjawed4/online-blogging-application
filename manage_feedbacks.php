<?php
	session_start();
  require_once("./required/database-class.php");
	if(isset($_SESSION["user"])){
		if($_SESSION["user"]->role_id==1){ 
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
                  Welcome
                  <?php echo $_SESSION["user"]->email ?>
                </h1>
                <div class="contatainer my-2">
							    <div class="row d-flex justify-content-center" id="view_user"></div>
						    </div>
                <div class="contatainer my-2">
							    <div class="row d-flex justify-content-center">
                    <div class="panel-body table-responsive">
                      <h1>Feedbacks</h1>
                      <p class="fw-bold text-primary">Blue: Registered User</p>
                      <p class="fw-bold text-danger">Red: Non Registered User</p>
                      <table class="table table-hover table-bordered" data-ordering="false" id="example">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Feedback</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $feedbacks=$database->get_feedback();
                            if($feedbacks->num_rows){
                              while($feedback=mysqli_fetch_object($feedbacks)){
                                ?>
                                <tr>
                                  <?php
                                    $users=$database->get_users();
                                    $class=null;
                                    while($user=mysqli_fetch_object($users))
                                      if($user->email==$feedback->user_email)   $class="text-primary"; 
                                    ?>
                                    <?php
                                  ?>
                                  <td class="<?php echo $class ? $class : 'text-danger'?> fw-bold"><?php 
                                  echo ucwords($feedback->user_name) ?></td>
                                  <td class="<?php echo $class ? $class : 'text-danger'?> fw-bold">
                                  <?php echo $feedback->user_email ?></td>
                                  <td><?php echo $feedback->feedback ?></td>
                                </tr>
                                <?php
                              }
                            }else echo "<h1 class='text-center'>No Feedback</h1>";
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
						    </div>
              </div>
            </div>
          </div>
          <?php
            include_once("./includes/footer.php");
            custom_footer("account");	
          }else header("location:./user.php");
        }else header("location:./login.php?login=true");
        ?>
  </body>
</html>
