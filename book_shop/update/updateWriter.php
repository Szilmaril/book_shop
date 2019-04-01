<?php
session_start();
require_once "../db.php";
$db = db::get();

$id = $db->escape($_GET["writerid"]);

$selectUser = "SELECT writer_picture FROM `writer` WHERE id =".$id;
$writers = $db->getArray($selectUser);

foreach ($writers as $writer) {
  $cover = $writer["writer_picture"];
}

if (isset($_POST["uploadPicture"])) {
  $target_dir = "../image/";
  $target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
  $uploadOk = 1;
  $imgname = "";
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (!empty(basename($_FILES["fileToUpload2"]["name"]))) 
  {
    $imgname = basename($_FILES["fileToUpload2"]["name"]);
  }
  else
  {
    $imgname = $cover;
  }

  if ($imgname != $cover) {
    $path = "../image/".$cover;
    chown($path,07777);
    unlink($path);
  }
  
  if(isset($_POST["UploadCover"])) {
    $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }
  }

  if ($_FILES["fileToUpload2"]["size"] > 5000000) {
    echo "<script>window.location.href='listWriter.php?error=big';</script>";
    $uploadOk = 0;
  }

  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "<script>window.location.href='listWriter.php?error=variation';</script>";
  $uploadOk = 0;
}

if ($uploadOk == 1) {
  if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
    $updatecoverQuery = "UPDATE `writer` SET `writer_picture` = '".$imgname."' WHERE `writer`.`id` = ".(int)$id;
    $update = $db->query($updatecoverQuery);
    var_dump($updatecoverQuery);
    echo "<script>window.location.href='listWriter.php?success=done';</script>";
  } else {
    echo "<script>window.location.href='listWriter.php?error=wrong';</script>";
  }

} else {
  echo "<script>window.location.href='listWriter.php?error=wrong';</script>";
}

}
?>