<?php 
session_start();

if (!isset($_SESSION["username"])) {
	header("location: index.php");
}
require_once "db.php";

$writername = $_GET["szerzoid"];
$writername = (int)$writername;
$selectString = "SELECT * FROM writer WHERE id =".$writername;

$db = db::get();
$writers = $db->getArray($selectString);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once("head.php"); ?>
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
	</head>
	<body class="bg">
		<div class="container text-center">
			<?php foreach($writers as $writer):?>
			<div class="card" style="background-color: rgba(255,255,255,.5);">
				<div class="card-header text-center">
					<h4>
						<?php echo $writer["writer_name"]; ?>
					</h4>
				</div>
				<div class="card-body text-center">
					<img src="image/<?php echo $writer["writer_picture"];?>" style="width: 45vw; height: 120vh; border-radius: 10px;">
				</div>
				<div class="card-footer">
					<h6>Születésnap: <?php echo $writer["writer_birthday"]; ?></h6><hr>
					<h6>Története:</h6><p><?php echo $writer["life_story"]; ?></p>
				</div>
				<?php endforeach; ?>
			</div>
				<a class="btn btn-success" href="list.php">Vissza<a>
		</div>
	</body>
</html>