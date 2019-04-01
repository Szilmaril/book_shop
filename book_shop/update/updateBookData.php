<?php 
	if (isset($_GET["bookid"])) {
		require_once "../db.php";
		$db = db::get();
		$id = $db->escape($_GET["bookid"]);
		$publishing = $db->escape($_POST["publishing"]);
		$story = $db->escape($_POST["story"]);
		$book_title = $db->escape($_POST["book_title"]);
		$lid = $db->escape($_POST["lid"]);
		$quantity = $db->escape($_POST["quantity"]);
		$language_id = $db->escape($_POST["language_id"]);
		$writer_id = $db->escape($_POST["writer_id"]);
		$category_id = $db->escape($_POST["category_id"]);

		if (empty($publishing) || empty($story) || empty($book_title) || empty($lid) || empty($quantity) || empty($language_id) || empty($writer_id) || empty($category_id)) {
			echo "<script>window.location.href='listBook.php?error=empty2';</script>";
		}

		$updateQuery = "UPDATE `book` SET 
		`publishing` = '".$publishing."',
		`story` = '".$story."',
		`book_title` = '".$book_title."',
		`lid` = '".$lid."',
		`quantity` = '".$quantity."',
		`language_id` = '".$language_id."',
		`writer_id` = '".$writer_id."',
		`category_id` = '".$category_id."'
		WHERE `book`.`book_id` = ".$id;
		$update = $db->query($updateQuery);
		echo "<script>window.location.href='listBook.php?success=done';</script>";
	}
	else
	{
		echo "<script>window.location.href='listBook.php?error=unknown';</script>";
	}
 ?>