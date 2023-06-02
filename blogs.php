<?php
	session_start();
	require_once("./required/database-class.php");
	  include_once("./includes/header.php");
		?>
		<div class="container my-5">
			<h1 class="text-center fs-1" style="color:#2DB0D0;">Blogs</h1>
			<div class="row my-4">
				<?php
					$blogs=$database->view_blogs("InActive");
					while($blog=mysqli_fetch_object($blogs)){
						?>
						<a href="./blog.php?id=<?php echo $blog->blog_id ?>" target="new">
							<div class="col-12 px-md-0 px-2 mb-5">
							 <img src="./assets/images/blogs/<?php echo $blog->blog_background_image ?>" alt="No Img" class="w-100" style="height: 450px" />
							<?php  
								$followers=0;
							$blog_follow=$database->following_blogs();
							while($follow=mysqli_fetch_object($blog_follow)){
								if($follow->blog_following_id==$blog->blog_id AND $follow->status=="Followed")$followers=$followers+1;
							}
							?>
							<div class="row d-flex justify-content-between">
								<div class="col-md-4 col-6">
									<button class="btn  btn-outline-light mt-1 fs-3"><?php echo $blog->blog_title ?></button>
								</div>
								<div class="col-md-4 col-6 text-end">
									<h3 class="fw-bold tex-end mt-1" style="color:#2DB0D0;">Followers:<?php echo $followers ?></h3>
								</div>
							</div>
							</div>
						</a>
						<?php
					}
				?>
			</div>

		</div>
		<?php
	  include_once("./includes/footer.php");
		custom_footer();
?>