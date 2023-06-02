<?php
  require_once("./required/database-class.php");
  function custom_footer($file="empty"){
    GLOBAL $database;
    ?>
    <footer class="text-center text-lg-start text-white footer-content">
        <div class="container p-4 pb-0">
          <section>
            <div class="row">
              <div class="col-lg-4 col-12 mb-4 mb-lg-0 px-4">
                <h5 class="text-uppercase">FOOTER CONTENT</h5>
                <p>
                  A blog (short for “weblog”) is an online journal or informational website run by an individual, group, or corporation that offers regularly updated content (blog post) about a topic. It presents information in reverse chronological order and it's written in an informal or conversational style.
                </p>
              </div>
              <div class="col-lg-2 col-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Blogs</h5>
                <ul class="list-unstyled mb-0">
                  <?php
                    $blogs=$database->updateblogdata("InActive");
                    $counter=0;
                    while($blog=mysqli_fetch_object($blogs)){
                      $counter++;
                      if($counter==5) break;
                      ?>
                       <li>
                        <a href="./blog.php?id=<?php echo $blog->blog_id ?>" class="text-white"><?php echo $blog->blog_title ?></a>
                      </li>
                      <?php
                    }
                  ?>
                </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4 mb-md-0">
                  <h5 class="text-uppercase">Categories</h5>
                  <ul class="list-unstyled mb-0">
                    <?php
                      $categories=$database->get_categories();
                      $counter=0;
                      while($category=mysqli_fetch_object($categories)){
                        $counter++;
                        if($counter==5) break;
                        ?>
                        <li>
                          <a  class="text-white"><?php echo $category->category_title ?></a>
                        </li>
                        <?php
                      }
                    ?>
                  </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4 mb-md-0">
                  <h5 class="text-uppercase">Posts</h5>
                  <ul class="list-unstyled mb-0">
                    <?php
                        $posts=$database->get_posts("SELECT * FROM `post` ORDER BY `post_id` DESC");
                        $counter=0;
                        while($post=mysqli_fetch_object($posts)){
                          $counter++;
                          if($counter==5) break;
                          ?>
                          <li>
                            <a href="./post.php?id=<?php echo $post->post_id ?>" class="text-white"><?php echo $post->post_title ?></a>
                          </li>
                          <?php
                        }
                      ?>
                  </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4 mb-md-0">
                  <h5 class="text-uppercase">Images</h5>
                  <div class="row">
                    <?php
                      $counter=0;
                      while($post=mysqli_fetch_object($posts)){
                      $counter++;
                      if($counter==5) break;
                        ?>
                        <div class="col-6 mb-3">
                          <img src="./assets/images/posts/<?php echo $post->featured_image ?>" alt="" class="w-100" style="height: 50px;">
                        </div>
                        <?php
                        }
                      ?>
                  </div>
                </div>
            </div>
          </section>
          <?php 
            if(!isset($_SESSION["user"])){
              ?>
              <hr class="mb-4" />
              <section class="">
                <p class="d-flex justify-content-center align-items-center">
                  <span class="me-3">Register for free</span>
                  <a href="./register.php" class="btn btn-outline-light btn-rounded">
                    Sign up!
                  </a>
                </p>
              </section>
              <?php
            } 
          ?>
          <hr class="mb-4" />
          <section class="mb-4 text-center icons-section">
            <a class="btn icons btn-floating m-1" href="#!" role="button">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a class="btn icons btn-floating m-1" href="#!" role="button">
              <i class="fab fa-twitter"></i>
            </a>
            <a class="btn icons btn-floating m-1" href="mailto:ahsanjawed2001@gmail.com" role="button">
              <i class="fab fa-google"></i>
            </a>
            <a class="btn icons btn-floating m-1" href="#!" role="button">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="btn icons btn-floating m-1" href="#!" role="button">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a class="btn icons btn-floating m-1" href="tel:+923053039453" role="button">
              <i class="fa fa-volume-control-phone"></i>
            </a>
          </section>
        </div>
        <div class="text-center p-3 copyright-section">
            <p>
              © <?php date_default_timezone_set("Asia/Karachi"); echo date("d-M-Y") ?> 
              Copyright:<a href="./index.php">Ahsan Jawed</a>
            </p>
        </div>
      </footer>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
      <?php
      if($file=="blogs" || $file=="categories" || $file=="posts" || $file=="comments" || $file=="account"){
      ?>
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
      <?php
      }
      ?>
      <script src="./assets/js/<?php echo $file ?>.js"></script>
      <?php
        if($file!="empty"){
          ?>
          <script src="./assets/js/modules.js"></script>
          <?php
        }
      ?>
    </body>
  </html>
    <?php
  }
?>