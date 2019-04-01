
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once ("../db.php");
if (!isset($_SESSION["username"])) {
		header("location: ../index.php");
	}
$db = db::get();
$selectUserDataQuery = "SELECT * FROM users WHERE username = '".$_SESSION["username"]."'";
$userData = $db->getArray($selectUserDataQuery);
if (isset($_GET["success"])) {
	$success = $db->escape($_GET["success"]);
}
if (isset($_GET["error"])) {
	$error = $db->escape($_GET["error"]);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once("../head.php"); ?>
		<link rel="stylesheet" href="../css/sweetalert2.min.css">
		<script src="../js/sweetalert2.all.min.js"></script>
		<style>
			.bg
			{
				background-image: url("http://www.budaorsiinfo.hu/wp-content/uploads/2013/12/konyv_illusztr.jpg");
				background-size: cover;
				background-repeat: none;
			}
			.bg img
			{
				height: 100%;
				width: 100%;
			}
			.input
			{
				-webkit-box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
				-moz-box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
				box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
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
			function okmsg(oktext)
			{
				Swal.fire(
					'Siker',
					oktext + '!',
					'success'
					)
			}
		</script>
	</head>
	<body class="bg">
		<?php 
  switch ($error) {
   case 'noMatch':
   echo "<script>errortext = 'A jelszavak nem egyeznek!'; errormsg(errortext);</script>";
   break;
   case 'invalidPW':
   echo "<script>errortext = 'Az új jelszavak nem egyeznek. Nem változtak!'; errormsg(errortext);</script>";
   break;
   case 'empty':
   echo "<script>errortext = 'Minden mezőt töltsön ki!'; errormsg(errortext);</script>";
   break;
   case 'wrongPW':
   echo "<script>errortext = 'Nincs jelszó módosítás!'; errormsg(errortext);</script>";
   break;
   case 'shortPW':
   echo "<script>errortext = 'A jelszó nincs minimum 8 karakter!'; errormsg(errortext);</script>";
   break;
   case 'already':
   echo "<script>errortext = 'Már létezik ilyen e-mail cím!'; errormsg(errortext);</script>";
   break;
   default:
     # code...
   break;
 }
 if ($success == "done") {
   echo "<script>oktext = 'Sikeres adatmódosítás!'; okmsg(oktext);</script>";
 }
 ?>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Beállítások</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="../list.php">Főoldal</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="listMyUser.php">Beállítások</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="../logout.php">Kilépés</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<div class="jumbotron" style="background-color: rgba(255,255,255,.5);"><h3><?php echo $_SESSION["username"]." "; ?>profiljának szerkesztése</h3></div>
			<?php foreach($userData as $user): ?>
			<form class="container form-group" action="setuserdata.php" method="post" class="form-group">
				<div class="form-row">
					<label for="emailAddress">E-mail cím:</label>
					<input type="email" id="emailAddress" name="emailAddress" class="input form-control" value="<?php if(!empty($user['email'])){echo $user['email'];} ?>" placeholder="Email cim" required="true">

					<label for="newPassword">Új jelszó:</label>
					<input type="password" id="newPassword" name="newPassword" class="input form-control" value="" placeholder="Új jelszó" required="true">

					<label for="newPassword2">Új jelszó megerősítés:</label>
					<input type="password" id="newPassword2" name="newPassword2" class="input form-control" value="" placeholder="Új jelszó megerősítés" required="true">

					<label for="birthday">Születésnap:</label>
					<input type="date" id="birthday" name="birthday" class="input form-control" value="<?php if(!empty($user['birthday'])){echo $user['birthday'];} ?>" required="true">

					<label for="currentPassword">Módosításhoz add meg jelenlegi jelszavad:</label>
					<input type="password" id="currentPassword" name="currentPassword" class="input form-control" value="" placeholder="Módosításhoz add meg jelenlegi jelszavad" required="true">

					<button class="btn btn-success" name="updateProfile">Mentes</button>
				</div>
			</form>
		<?php endforeach; ?>
		</div>
	</body>
</html>
