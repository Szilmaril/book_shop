<?php
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	require_once "../db.php";
	
	if ($_SESSION["username"] != "admin") {
		header("location: index.php");
	}
	$db = db::get();
	
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
			case 'nopict':
			echo "<script>errortext = 'A fájl nem kép!'; errormsg(errortext);</script>";
			break;
			case 'fault':
			echo "<script>errortext = 'Hiba történt a feltöltéskor!'; errormsg(errortext);</script>";
			break;
			case 'already':
			echo "<script>errortext = 'A kép már szerepel az adatbázisban!'; errormsg(errortext);</script>";
			break;
			case 'wrong':
			echo "<script>errortext = 'A fájlt nem sikerült feltölteni!'; errormsg(errortext);</script>";
			break;
			case 'big':
			echo "<script>errortext = 'A kép túl nagy!'; errormsg(errortext);</script>";
			break;
			case 'variation':
			echo "<script>errortext = 'Csak JPG, JPEG, PNG és GIF típusu képek engedélyezettek!'; errormsg(errortext);</script>";
			break;
			default:
			# code..
			break;
		}
		if ($success == "done") {
			echo "<script>oktext = 'Sikeres feltöltés!'; okmsg(oktext);</script>";
		}
	?>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Adatfeltöltés</a>
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
						<a class="nav-link" href="uploadBook.php">Könyv kiadás feltöltés</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="uploadWriter.php">Író feltöltés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="uploadCategory.php">Műfaj feltöltés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="uploadLanguage.php">Nyelv feltöltés</a>
					</li>
				<?php endif; ?>
				</ul>
			</div>
		</nav>
		
    <div class="container">
        <form class="container form-group text-center" action="" method="POST" enctype="multipart/form-data">
            <label>Név: </label>
			<input type="text" class="input form-control" name="writer_name" required="true"><br>
			<label>Születésnap: </label>
			<input type="date" class="input form-control" name="writer_birthday" required="true"><br>
			<label>Kép: </label>
			<input type="file" name="fileToUpload" required="true"><br>
			<label>Leírás: </label>
			<textarea name="life_story" class="input form-control" id="" rows="3" required="true"></textarea><br>
			
            <button type="submit" name="submit" class="btn btn-success">Feltöltés</button>
        </form>
    </div>
    <?php 
        if(isset($_POST["submit"])) {
  
        $writer_name = $db->escape($_POST["writer_name"]);
        $writer_birthday = $db->escape($_POST["writer_birthday"]);
        $life_story = $db->escape($_POST["life_story"]);

        $target_dir = "../image/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
               
                $uploadOk = 1;
            } else {
                echo "<script>window.location.href='uploadWriter.php?error=nopict'</script>";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            echo "<script>window.location.href='uploadWriter.php?error=already'</script>";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "<script>window.location.href='uploadWriter.php?error=big'</script>";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "<script>window.location.href='uploadWriter.php?error=variation'</script>";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>window.location.href='uploadWriter.php?error=wrong'</script>";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        	$writer_picture = basename($_FILES["fileToUpload"]["name"]);
        	
            $uploadPictureSql = "INSERT INTO `writer` (
			`writer_name`,
			`writer_picture`,
			`writer_birthday`,
			`life_story`
			) VALUES (
			'".$writer_name."',
			'".$writer_picture."',
			'".$writer_birthday."', 
			'".$life_story."')";
            $query = $db->query($uploadPictureSql);


        } else {
            echo "<script>window.location.href='uploadWriter.php?error=fault'</script>";
        }
		echo "<script>window.location.href='uploadWriter.php?success=done'</script>";
    }

}
?>

</body>
</html>