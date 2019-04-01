<?php
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	require_once "../db.php";
	
	if ($_SESSION["username"] != "admin") {
		header("location: ../index.php");
	}
	
	$db = db::get();
	$selectString = "SELECT * FROM book LEFT JOIN category ON category_id = category.id LEFT JOIN writer ON writer_id = writer.id LEFT JOIN languages ON language_id = languages.id";
	$books = $db->getArray($selectString);
	
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
			echo "<script>errortext = 'Jelenleg nincs egy könyv sem, töltsön fel párat!'; errormsg(errortext);</script>";
			break;
			case 'empty2':
			echo "<script>errortext = 'Töltsön ki minden mezőt!'; errormsg(errortext);</script>";
			break;
			case 'unknown':
			echo "<script>errortext = 'Ismeretlen hiba!'; errormsg(errortext);</script>";
			break;
			case 'big':
			echo "<script>errortext = 'A kép túl nagy!'; errormsg(errortext);</script>";
			break;
			case 'variation':
			echo "<script>errortext = 'Nem cserélt képet, vagy rossz formátumot választott, csak JPG, JPEG, PNG és GIF típusu képek engedélyezettek!'; errormsg(errortext);</script>";
			break;
			case 'wrong':
			echo "<script>errortext = 'A könyvet nem sikerült szerkeszteni!'; errormsg(errortext);</script>";
			break;
			default:
			# code..
			break;
		}
		if ($success == "done") {
			echo "<script>oktext = 'Sikeres szerkesztés!'; okmsg(oktext);</script>";
		}
	?>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Adatszerkesztés</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
				<?php if($_SESSION["username"] == "admin"): ?>
					<li class="nav-item">
						<a class="nav-link" href="../list.php">Főoldal</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="listBook.php">Könyv kiadás szerkesztés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="listWriter.php">Író szerkesztés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="listCategory.php">Műfaj szerkesztés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="listLanguage.php">Nyelv szerkesztés</a>
					</li>
				<?php endif; ?>
				</ul>
			</div>
		</nav>
		
		<?php if(count($books) == 0):?>
			<?php echo "<script>window.location.href='listBook.php?error=empty'</script>"; ?>
		<?php else:?>
			<?php foreach($books as $book):?>
				<div class="container text-center">
					<div class="card" style="background-color: rgba(255,255,255,.5);">
						<div class="card-header text-center">
							<h4 style="text-decoration: none; color: black;">
								<?php echo $book["book_title"]; ?>
							</h4>
						</div>
						<div class="card-body text-center">
							<img src="../image/<?php echo $book["cover_image"];?>" style="width: 45vw; height: 120vh; border-radius: 10px;">
						</div>
						<div class="card-footer">
							<h6>Műfaj: <?php echo $book["genre"]; ?></h6><hr>
							<h6>Megjelenési dátum: <?php echo $book["publishing"]; ?></h6><hr>
							<h6> Nyelv: <?php echo $book["language"]; ?></h6><hr>
							<h6>Fedéltípus: <?php echo $book["lid"]; ?></h6><hr>
							<h6><?php echo $book["story"]; ?></h6><hr>
							<h6><?php echo $book["writer_name"]; ?></h6><hr>
							<a href="updateBooks.php?bookid=<?php echo $book["book_id"];?>">Szerkesztés</a>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		<?php endif; ?>
	</body>
</html>
