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
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-xl gradient-navbar sticky-top">
      <div class="container-fluid">
        <a class="navbar-brand mt-2" href="./index.php"><h3 class="p-2">Online Blogging</h3></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-items">
              <a class="nav-link menu" href="./index.php">Home</a>
            </li>
            <li class="nav-items">
              <a class="nav-link menu" href="./about-us.php">About Us</a>
            </li>
            <li class="nav-items">
                  <a class="nav-link menu" href="./blogs.php">Blogs</a>
              </li>
            <li class="nav-items">
              <a class="nav-link menu" href="./feedback.php">Feedback</a>
            </li>
          </ul>
          <?php
            if(isset($_SESSION["user"])){
              ?>
              <a href="<?php echo $_SESSION["user"]->role_id===1 ? "./admin.php" :"./user.php" ?>" class="btn btn_login mt-1 mx-2"> Dashboard</a>
              <a href="./logout.php" class="btn btn_login mt-1 mx-2">Logout</a>
              <?php
            }else {
              ?>
              <a href="./register.php" class="btn btn_login mt-1 mx-2">Register</a>
              <a href="./login.php" class="btn btn_login mt-1">Login</a>
              <?php
            }
          ?>
        </div>
      </div>
    </nav>