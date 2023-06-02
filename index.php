<?php
  session_start();
  require_once("./required/custom-functions.php");
  require_once("./required/database-class.php");
  include_once("./includes/header.php");
  if(isset($_COOKIE["name"])){
    echo "<ul>";
      echo $_COOKIE["name"];
    echo "</ul>";
  }
  if(isset($_REQUEST["user"]))
    error_modal("You need to logout first.");
  ?>
  <!-- Carousel Start -->
  <div id="carouselExampleAutoplaying" class="container my-5 carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php
        $carousel=$database->view_blogs("InActive");
        $counter=null;
        while($carousel_item=mysqli_fetch_object($carousel)){
          $counter++;
          ?>
          <div class="carousel-item <?php echo $counter==1 ? 'active' : '' ?>">
            <img src="./assets/images/blogs/<?php echo $carousel_item->blog_background_image ?>" class="carousel_img" alt="No Images"/>
          </div>
          <?php
        }
      ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- Carousel end -->
  <!-- Post Start -->
  <div class="container posts my-5">
    <div class="row">
    <div class="col-md-8 order-md-1 order-2">
      <h1 class="px-lg-0 px-5">Posts</h1>
      <div class="row d-flex justify-content-end">
        <div class="col-lg-6 px-5 mb-4">
        <input type="email" class="form-control border-lg fs-5" id="search_post" placeholder="Search Post" onkeyup="searchPost()"/>
        </div>
      </div>
      <div class="row d-flex justify-content-center" id="index_posts"></div>
    </div>
    <div class="col-md-4 order-md-2 order-1 mb-5">
      <h1 class="px-4 text-md-start text-center">Recent Posts</h1>
        <div class="row d-flex justify-content-center">
          <?php
            $posts=$database->get_posts("SELECT * FROM `post` ORDER BY `post_id` DESC");
            $counter=0;
            while($post=mysqli_fetch_object($posts)){
              if($post->post_status=="Active"){
                $counter++;
                ?>
                <div class="col-10 mb-4">
                  <div class="card py-0">
                    <a href="./post.php?id=<?php echo $post->post_id ?>">
                    <img class="card-img-top" src="./assets/images/posts/<?php
                    echo $post->featured_image ?>" alt="Card image cap">
                    <div class="card-body">
                    <h4 class="card-title post_title"><?php echo strlen($post->post_title)>27 ? substr($post->post_title,0,27) ."..." : $post->post_title ?></h4>
                    </div>
                    </a>
                  </div>
                </div>
                <?php
              }
              if($counter==5) break;
            }
          ?>
        </div>
      </div>
      </div>
    </div>
  <script>
    function index_posts(){
      var obj;
      if(window.XMLHttpRequest) obj=new XMLHttpRequest();
      else obj=new ActiveXObject("Microsoft.XMLHTTP");
      obj.onreadystatechange=function(){
        if(obj.readyState==4 && obj.status==200 && obj.statusText=="OK"){
          document.querySelector("#index_posts").innerHTML=obj.responseText;
        }
      }
      obj.open("GET","actions.php?index_posts=true");
      obj.send();
    }
    index_posts();
    function searchPost(){
      var obj;
      if(window.XMLHttpRequest) obj=new XMLHttpRequest();
      else obj=new ActiveXObject("Microsoft.XMLHTTP");
      obj.onreadystatechange=function(){
        if(obj.readyState==4 && obj.status==200 && obj.statusText=="OK"){
          document.querySelector("#index_posts").innerHTML=obj.responseText;
        }
      }
      obj.open("POST","actions.php");
      obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
      obj.send("search_post=true&value="+document.querySelector("#search_post").value);
    }
  </script>
  <!-- Posts end -->
  <?php
  include_once("./includes/footer.php");
	custom_footer();
?>
