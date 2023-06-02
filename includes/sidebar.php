	<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar">
		<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
			<a href="./index.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none px-3 mt-5">
				<span class="fs-5 d-none d-sm-inline">
					<h4 class="p-lg-2 p-1">Online Blogging</h4>
				</span>
			</a>
			<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
				<li class="nav-item">
					<a href="./index.php" class="nav-link align-middle px-0" title="Home">
						<i class="fa-solid fa-house"></i> 
						<span class="ms-1 d-none d-sm-inline">Home</span>
					</a>
				</li>
				<?php
				if($_SESSION["user"]->role_id=="1"){
					?>
						<li>
							<a href="./admin.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Manage Users"
							onclick="manage('admin')">
								<i class="fa-solid fa-users"></i>
								<span class="ms-1 d-none d-sm-inline">Manage Users</span>
							</a>
						</li>
						<li>
						<a href="./manage_blogs.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Manage Blogs" 
						onclick="manage('manage_blogs')">
							<i class="fa-brands fa-blogger-b"></i> 
							<span class="ms-1 d-none d-sm-inline">Manage Blogs</span></a>
						</li>
						<li>
							<a href="./manage_categories.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Manage Categories"
							onclick="manage('manage_categories')">
								<i class="fa-sharp fa-solid fa-sitemap"></i>
								<span class="ms-1 d-none d-sm-inline">Manage Categories</span>
							</a>
						</li>

						<li>
							<a href="./manage_posts.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Manage Posts"
							onclick="manage('manage_posts')">
								<i class="fa-brands fa-blogger-b"></i> 
								<span class="ms-1 d-none d-sm-inline">Manage Posts</span>
							</a>
						</li>
						<li>
							<a href="./manage_comments.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Manage Comments" onclick="manage('manage_comments')">
								<i class="fa-solid fa-comments"></i>
								<span class="ms-1 d-none d-sm-inline fs-5">Manage Comments</span>
							</a>
						</li>
						<li>
							<a href="./manage_feedbacks.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Feedbacks"
							onclick="manage('manage_feedbacks')">
								<i class="fa-solid fa-people-arrows"></i>
								<span class="ms-1 d-none d-sm-inline">Feedbacks</span>
							</a>
						</li>
						<?php
					}
					?>
					<li>
						<a href="" data-bs-toggle="collapse" class="nav-link px-0  align-middle" title="Edit Account"
						onclick="view_user('<?php echo $_SESSION['user']->user_id ?>')">
							<i class="fa-solid fa-address-card"></i>
							<span class="ms-1 d-none d-sm-inline">View Account</span>
						</a>
					</li>
					<li>
						<a href="" data-bs-toggle="collapse" class="nav-link px-0  align-middle" title="Edit Account" 
						onclick="edit_user('<?php  echo $_SESSION['user']->user_id ?>')
						">
							<i class="fa-solid fa-address-card"></i>
							<span class="ms-1 d-none d-sm-inline">Edit Account</span>
						</a>
					</li>
					<li>
						<a href="./logout.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle" title="Logout" onclick="logout()">
							<i class="fa-solid fa-gear"></i> 
							<span class="ms-1 d-none d-sm-inline">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>