<?php
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	require_once "../db.php";
	
	if ($_SESSION["username"] != "admin") {
		header("location: ../index.php");
	}
	
	$selectString = "SELECT * FROM users";
	$db = db::get();
	$allusers = $db->getArray($selectString);
	
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
			case 'empty':
			echo "<script>errortext = 'Jelenleg nincs egy felhasználó sem!'; errormsg(errortext);</script>";
			break;
			case 'empty2':
			echo "<script>errortext = 'Minden mezőt töltsön ki!'; errormsg(errortext);</script>";
			break;
			case 'copy':
			echo "<script>errortext = 'Nem változtatott felhasználónevet, vagy már foglalt!'; errormsg(errortext);</script>";
			break;
			case 'copy2':
			echo "<script>errortext = 'Nem változtatott e-mail címet, vagy már foglalt!'; errormsg(errortext);</script>";
			break;
			default:
			# code..
			break;
		}
		if ($success == "done") {
			echo "<script>oktext = 'Sikeres adatmódosítás!'; okmsg(oktext);</script>";
		}
	?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">Felhasználólista</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
			<?php if($_SESSION["username"] == "admin"): ?>
				<li class="nav-item">
					<a class="nav-link" href="../list.php">Főoldal</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="listUser.php">Felhasználólista szerkesztés</a>
				</li>
			<?php endif; ?>
			</ul>
		</div>
	</nav>

		<?php if(count($allusers) == 0):?>
			<?php echo "<script>window.location.href='listUser.php?error=empty'</script>"; ?>
		<?php else:?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Felhasználónév</th>
						<th>E-mail cím</th>
						<th>Születésnap</th>
						<th>Szerkesztés</th>
						<th>Törlés</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach($allusers as $users):?>
				<?php if($users["username"] != "admin"): ?>
				<tr>
					<td><?php echo $users["id"]; ?></td>
					<td><?php echo $users["username"]; ?></td>
					<td><?php echo $users["email"]; ?></td>
					<td><?php echo $users["birthday"]; ?></td>
					<td><a class="btn btn-success" href="updateUser.php?usersid=<?php echo $users["id"];?>">Szerkesztés</a></td>
					<td><a class="btn btn-danger" href="deleteUser.php?usersid=<?php echo $users["id"];?> ">Törlés</a></td>
				</tr>
			<?php endif; ?>
			<?php endforeach;?>
		<?php endif;?>
		
	</body>
</html>