<?php 
	if(isset($_GET["categoryid"])){
		require_once "../db.php";
		$db = db::get();
		$id = $db->escape($_GET["categoryid"]);
		if(isset($_POST["submitForm"])){
			$genre = $db->escape($_POST["genre"]);
			if(empty($genre)){
				echo "<script>window.location.href='listCategory.php?error=empty'</script>";
			}else{
				$checkCategoryQuery = "SELECT * FROM category WHERE genre ='".$genre."'";
				$check = $db->getArray($checkCategoryQuery);
				
					if (empty($check)) {
						$updateString = "UPDATE category SET
							`genre`='".$genre."'
						WHERE id=".$id;
						$db->query($updateString);
						echo "<script>window.location.href='listCategory.php?success=done'</script>";
					}else{
						echo "<script>window.location.href='listCategory.php?error=copy'</script>";
					}
				}
			}
		$selectString = "SELECT * FROM category WHERE id=".$id;
		$category = $db->getRow($selectString);
	}else{
		header("Location: listCategory.php");
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
		.input
		{
			-webkit-box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
			-moz-box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
			box-shadow: inset 13px 6px 26px -2px rgba(0,0,0,0.75);
		}
		</style>
	</head>
	<body class="bg">
		<form class="container form-group text-center" action="" method="POST">
				Műfaj:
			<input type="text" class="input form-control" name="genre" value="<?php echo (isset($category)) ? $category["genre"] : "" ; ?>"><br>
			<button type="submit" name="submitForm" class="btn btn-success">Mentés</button>
			<a href="listCategory.php" class="btn btn-primary">Vissza</a>
		</form>
	</body>
</html>