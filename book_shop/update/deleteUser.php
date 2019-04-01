<?php 
	if(isset($_GET["usersid"])){
		require_once "../db.php";
		$db = db::get();
		$id = $db->escape($_GET["usersid"]);
		if(isset($_POST["submitForm"])){
			$deleteString = "DELETE FROM users WHERE id=".$id;
			$db->query($deleteString);
			header("Location: listUser.php");
			exit();
		}
		$selectString = "SELECT * FROM users WHERE id=".$id;
		$users = $db->getRow($selectString);
	}else{
		header("listUser.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once("../head.php"); ?>
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
	<div class="text-center">
		<h2>Biztos törli a(z):</h2>
			<?php  if(isset($users)){echo $users["username"];}	?> 
		<h2>felhasználót?</h2>
		<form action="" method="POST">
			<button type="submit" class="btn btn-success" name="submitForm">
				Igen
			</button>
			<a href="listUser.php" class="btn btn-primary">
					Mégse
			</a>
		</form>
	</div>
	</body>
</html>