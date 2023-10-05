<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz</title>
  </head>
  <body>
	<!-- Main page explaining what the general system is and how it works -->
    <div class="container-fluid" style="height: auto; background-color: #eee; padding-top: 3vh;">
		<div class="row">
			<a href="Login.php" class="btn btn-outline-secondary" style="width: 10vw; margin-left: 85vw;">Log In</a>
		</div>
    </div>
    
    <div class="container-fluid" style="background-color: #eee; padding: 25vh 10vw; height: 95vh;">
		<div class="row">
			<h1 class="display-1">School Quiz</h1>
			<p class="lead">Propell your maths ability further with customised tests that adapt to your ability.</p>
		</div>
		<div class="row">
			<div class="col">
			<a href="Register.php" class="btn btn-lg btn-primary">Sign Up</a>
			</div>
		</div>
    </div>

	<div class="container-fluid" style="padding: 5vh 5vw;">
		<div class="row">
			<div class="col" style="height: 50%; margin-top: 10%;">
				<h3>What is School Quiz?</h3>
				<p class="lead">
					School Quiz is a system that allows you to test your maths ability on various topics.
				</p>
			</div>
			<div class="col">
				<img src="images/image_one.jpg" alt="" class="img-thumbnail border-0">
			</div>
		</div>
		<div class="row" style="margin-top: 5vh;">
			<div class="col">
				<img src="images/image_two.jpg" alt="" class="img-thumbnail border-0">
			</div>
			<div class="col" style="height: 50%; margin-top: 10%;">
				<h3>How does it work?</h3>
				<p class="lead">
					School Quiz analyses your answers as you progress through quizes. <br>
					<br>
					The more you get <strong>correct</strong> the <strong>harder</strong> the questions. <br>
					The more you get <strong>wrong</strong> the <strong>easier</strong> the questions. <br>
				</p>
			</div>
		</div>
	</div>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
