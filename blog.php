<?php
  session_start();
  if(isset($_SESSION["user"])){
		if(isset($_REQUEST["id"])){
			require_once("./required/database-class.php");
			$post_idees="";
			$posts=$database->blog_post();
			while($post=mysqli_fetch_object($posts)){
				if($post->blog_id==$_REQUEST["id"]) $post_idees.=$post->post_id.",";
			}
			$blog=$database->view_blogs("Inactive");
				$data=null;
			while($record=mysqli_fetch_object($blog)) 
				if($record->blog_id==$_REQUEST["id"]) $data=$record;
			include_once("./includes/header.php");
			if($data){
					$post_idees=substr($post_idees, 0,-1);
				?>
					<input type="hidden" id="post_per_page" value="<?php echo $data->post_per_page ?>"/>
					<input type="hidden" id="post_idees" value="<?php echo $post_idees ?>"/>
					<div class="container">
						<!-- <h1 class="text-center my-5" style="color:#2DB0D0">Blog</h1> -->
						<div class="row d-flex my-5 align-items-center">
							<div class="col-12 mb-4 px-lg-0 px-4" id="blog_bg">
								<img src="./assets/images/blogs/<?php echo $data->blog_background_image ?>" alt="No Img" class="w-100" />
							</div>
								<div class="col-4">
									<h1 class="text-primary fw-bold fs-1 mt-2 mx-3" style="color:#2DB0D0">
										<?php echo ucwords($data->blog_title) ?>
									</h1>
								</div>
								<div class="col-4" id="folow-btn"></div>
						</div>
						<h1>Categories:</h1>
						<div class="row d-flex mb-4">
							<div class="col-12">
									<button class="btn btn-md btn-outline-light mx-2" onclick="checkCategory('')">All</button>
									<?php
									$cats=$database->get_post_categories($post_idees);
									while($categories=mysqli_fetch_object($cats)){
											?>
										<button class="btn btn-md btn-outline-light mx-2" 
										onclick="checkCategory('<?php echo $categories->category_title ?>')">
											<?php echo $categories->category_title?></button>
										<?php
										?>
										<?php
									}
								?>
							</div>
						</div>
						<div class="row d-flex mb-5 justify-content-center" id="post_with_cat">
						</div>
					</div>
					</div>
					<input type="hidden" id="follower_id" value="<?php echo $_SESSION["user"]->user_id ?>"/>
					<input type="hidden" id="blog_following_id" value="<?php echo $_REQUEST["id"] ?>"/>
					<input type="hidden" id="blog_user_id" value="<?php echo $data->user_id ?>"/>
				<?php
			}else{echo "<h1 class='text-center my-5 text-danger'>No Blog is found Or Blog is InActive</h1>";}
			include_once("./includes/footer.php");
			custom_footer("blog_follower");
		}else header("location:./blogs.php");
  }else header("location:./login.php?login=true");
?>

