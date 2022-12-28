<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<link rel="shortcut icon" href="faviconerpp.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css" />
	<link rel="shortcut icon" href="img/loh.png" />
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
	<title>Finance System | Juragan It Web</title>

</head>

<body>
	<div class="container">
		<div class="forms-container">
			<div class="signin-signup">
				<form method="post" action="cek_login.php" class="sign-in-form">
					<img src="img/loga.png">
					<h2 class="title">Welcome</h2>
					<?php
					if (isset($_GET['sukses'])) {
						echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
					</div>";
					} elseif (isset($_GET['gagal'])) {
						echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
					 <strong>Gagal!</strong> - Maaf Login Gagal, Silahkan Isi Username dan Password Anda Dengan Benar
					</div>";
					}
					?>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="Username" name="a" />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" placeholder="Password" name="b" />
					</div>
					<input type="submit" value="Login" class="btn solid" name="login" />
				
				</form>
				<form action="#" class="sign-up-form">
					<h2 class="title">Sign up</h2>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="Username" />
					</div>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" placeholder="Email" />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" placeholder="Password" />
					</div>
					<input type="submit" class="btn" value="Sign up" />
					<p class="social-text">Or Sign up with social platforms</p>
					<div class="social-media">
						<a href="#" class="social-icon">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-twitter"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-google"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div>
				</form>
			</div>
		</div>

		<div class="panels-container">
			<div class="panel left-panel">
				<div class="content">
					<h3>Finance System</h3>
					<p>
						Manajemen Keuangan Perusahaan dalam Satu Genggaman
					</p>
					<!-- <button class="btn transparent" id="sign-up-btn">
						Sign up
					</button> -->
				</div>
				<img src="img/log.svg" class="image" alt="" />
			</div>
			<div class="panel right-panel">
				<div class="content">
					<h3>One of us ?</h3>
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
						laboriosam ad deleniti.
					</p>
					<button class="btn transparent" id="sign-in-btn">
						Sign in
					</button>
				</div>
				<img src="img/register.svg" class="image" alt="" />
			</div>
		</div>
	</div>

	<script src="js/app.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>