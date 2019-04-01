<?php
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	require_once "db.php";
	$db = db::get();

	if (isset($_GET["error"])) {
	$error = $db->escape($_GET["error"]);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once("head.php"); ?>
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/sweetalert2.min.css">
	<script src="js/sweetalert2.all.min.js"></script>
	<style>
		html, body {
			overflow: hidden;
		}
	</style>
	<script>
		function errormsg(errortext)
			{
				Swal.fire({
					type: 'error',
					title: 'Hiba',
					text: errortext + "!",
				})
			}
	</script>
</head>
<body background="image/login.jpg">
	<?php 
		switch ($error) {
			case 'wrong':
			echo "<script>errortext = 'Hibás jelszó vagy felhasználónév'; errormsg(errortext);</script>";
			break;
			case 'empty':
			echo "<script>errortext = 'Töltsön ki minden mezőt'; errormsg(errortext);</script>";
			break;
			default:
			# code...
			break;
		}
	?>
	<div class="container" style="margin-top: 5%;">
		<div class="text-center">
			<form action="" method="POST">
				<div class='box2'>
					<img src='image/login.jpg' style="opacity: 0;">
					<div class='box-content'>
						<div class='inner-content'>
							<h3 class='title text-center'>Bejelentkezés</h3>
							<span class='post'>
								<div class='container text-center'>
									<div class='form-roup'>
										<form method='POST'>
											<div class='form-row'>
												<div class='col'>
													<input type='text' name='username' id="username" class='input' placeholder='felhasználónév' style="color: white;">
													<input class='input' type='password' id="password" name='password' placeholder='jelszó'  style="color: white;">
												</div>		
											</div>
											<div class='form-row'>
												<div class='col'>
													<br>
													<button class='btn btn-success' name='login' >Bejelentkezés</button>
													<a class='btn btn-primary' name='login' href="index.php">Regisztráció</a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php 
	if(isset($_POST["login"])){
		$username = $db->escape($_POST["username"]);
		$password = $db->escape($_POST["password"]);
		$passwordhashed = md5($password);
		if(empty($username) || empty($password)){
			echo "<script>window.location.href='login.php?error=empty'</script>";
		}
		else
		{
			$selectString = "SELECT * FROM users where `username`='$username' && `password` = '$passwordhashed' LIMIT 1";
			$userCheck = $db->getArray($selectString);
			if(count($userCheck) == 0){
				echo "<script>window.location.href='login.php?error=wrong'</script>";
			}else{
				$_SESSION["username"] = $username;
				header("Location: list.php");
			}
		}
	}
?>
</body>
</html>