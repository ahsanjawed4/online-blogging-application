<?php
	session_start();
	include_once("./includes/header.php");
	?>
	<div class="container my-5">
		<h1 class="text-center fw-bold" style="color: #2DB0D0;">Hi I'm Ahsan Jawed!</h1>
		<div class="row">
			<div class="col-md-6">
				<div id="carouselExampleAutoplaying" class="container my-5 carousel slide mb-5" data-bs-ride="carousel">
				<div class="carousel-inner">
						<?php
					$img=["1.jpeg","3.jpeg"];
					for($a=0;$a<=sizeof($img)-1; $a++){
						?>
							<div class="carousel-item <?php echo $a==0 ? "active" :"" ?>">
								<img src="./assets/images/about/<?php echo $img[$a] ?>" class="carousel_img" alt="No Images" style="height: 600px;"/>
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
			</div>
			<div class="col-md-6 pt-5">
				<h2>Introduction</h2>
				<p>I am a construction business owner, part time marketer, and soon to be web developer.<br/>
				I love the internet, technology, and building beautiful things.</p>
				<h2>Where I'm From</h2>
				<p>I'm originally from Karachi, Pakistan.</p>
				<h2>More About Me</h2>
				<p class="fw-bold">What are your favorite hobbies?</p>
				<p>My favorite hobby is building things on the internet like ecommerce sites and email marketing campaigns.</p>
				<h2>What's your dream job?</h2>
				<p>My dream job is similar to my current job except I would like to be building software instead of buildings.</p>
				<h2>Where do you live?</h2>
				<p>I live on a urban acreage, but I'm close to Arabian Sea.</p>
				<h2>Why do you want to be a web developer?</h2>
				<p>Because programming is awesome and programming for the internet is even more awesome</p>
			</div>
		</div>
	</div>
	<?php
	include_once("./includes/footer.php");
	custom_footer("empty");
?>