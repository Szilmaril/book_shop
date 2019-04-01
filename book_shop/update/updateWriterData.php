<?php 
	if (isset($_GET["writerid"])) {
		require_once "../db.php";
		$db = db::get();
		$id = $db->escape($_GET["writerid"]);
		$writer_name = $db->escape($_POST["writer_name"]);
		$writer_birthday = $db->escape($_POST["writer_birthday"]);
		$life_story = $db->escape($_POST["life_story"]);

		if (empty($writer_name) || empty($writer_birthday) || empty($life_story)) {
			echo "<script>window.location.href='listWriter.php?error=empty2';</script>";
		}

		$updateQuery = "UPDATE `writer` SET 
		`writer_name` = '".$writer_name."',
		`writer_birthday` = '".$writer_birthday."',
		`life_story` = '".$life_story."'
		WHERE `writer`.`id` = ".$id;
		$update = $db->query($updateQuery);
		echo "<script>window.location.href='listWriter.php?success=done';</script>";
	}
	else
	{
		echo "<script>window.location.href='listWriter.php?error=unknown';</script>";
	}
 ?>