<?php
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if (isset($_SESSION["username"])) {
        header("location: list.php");
    }
    require_once "db.php";
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
        <?php require_once("head.php"); ?>
        <link rel="stylesheet" href="css/sweetalert2.min.css">
        <script src="js/sweetalert2.all.min.js"></script>
        <style>
            body
            {
                background-image: url("image/bg.jpg");
                background-repeat: no-repeat;
                background-size: cover;
            }
            .jumbotrontext
            {
                background-color: rgba(255,255,255,.3);
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
        </script>
    </head>
    <body>
<?php
  switch ($error) {
   case 'noMatch':
   echo "<script>errortext = 'A jelszavak nem egyeznek!'; errormsg(errortext);</script>";
   break;
   case 'wrongE':
   echo "<script>errortext = 'Az e-mail cím hibás formátumu!'; errormsg(errortext);</script>";
   break;
   case 'empty':
   echo "<script>errortext = 'Töltsön ki minden mezőt!'; errormsg(errortext);</script>";
   break;
   case 'shortPW':
   echo "<script>errortext = 'A jelszó nincs minimum 8 karakter!'; errormsg(errortext);</script>";
   break;
   case 'userWxists':
   echo "<script>errortext = 'Létezik már ilyen felhasználónév!'; errormsg(errortext);</script>";
   break;
   default:
     # code...
   break;
 }
 ?>
        <div class="container">
            <div class="jumbotron jumbotrontext text-center">
			<h2>Üdvözlünk a használt könyv üzlet weboldalán!</h2>
			<p>Ha már van felhasználója kattintson a "Bejelentkezés" gombra és jelnetkezzen be, ha nincs adja meg a kívánt adatait, és kattintson a "Regisztráció" gombra.</p>
			</div>
            <form class="container form-group" action="" method="POST" style="color: white;">
                <div class="form-row">
                    <label for="username">Felhasználónév: </label>
                    <input type="text" id="username" name="username" class="input form-control" id="username" value="<?php echo (isset($users)) ? $users["username"] : "" ; ?>">
                </div>
                <div class="form-row">
                    <label>Jelszó: </label>
                    <input type="password" class="input form-control" name="password" id="password" value="<?php echo (isset($users)) ? $users["password"] :"";?>">
                </div>
                <div class="form-row">
                    <label>Jelszó ellenörzés: </label>
                    <input type="password" class="input form-control" name="password_confirmation" id="passwordConfirmation" value="<?php echo (isset($users)) ? $users["password"] :"";?>">
                </div>
                <div class="form-row">
                    <label>Email: </label>
                    <input type="email" class="input form-control" name="email" id="email" value="<?php echo (isset($users)) ? $users["email"] :"";?>"><br>
                </div>
 
                <div class="form-row">
                    <label>Születésnap: </label>
                    <input type="date" class="input form-control" name="birthday" id="birthday" value="<?php echo (isset($users)) ? $users["birthday"] :""; ?>">
                </div>
                <hr>
                <div class="form-row">
                    <button class="btn btn-success" type="submit" name="submitForm">Regisztráció</button>
                    <a class="btn btn-info" href="login.php" class="btn btn-primary">Bejelentkezés</a>
                </div>
            </form>
        </div>
       
    </body>
</html>
<?php
    if(true){
        if(isset($_POST["submitForm"])){
            $username = $db->escape($_POST["username"]);
            $password = $db->escape($_POST["password"]);
            $email = $db->escape($_POST["email"]);
            $birthday = $db->escape($_POST["birthday"]);
            $password_confirmation = $db->escape($_POST["password_confirmation"]);
            if(empty($username) || empty($password) || empty($email) || empty($birthday)){
                echo "<script>window.location.href='index.php?error=empty'</script>";
        }else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                echo "<script>window.location.href='index.php?error=wrongE'</script>";
            }else if(strlen(trim($password)) < 8){
                echo "<script>window.location.href='index.php?error=shortPW'</script>";
            }else if($password != $password_confirmation){
                    echo "<script>window.location.href='index.php?error=noMatch'</script>";
            }else{
                    $checkIfUserExistQuery = "SELECT * FROM users WHERE username ='".$username."'";
                    $check = $db->getArray($checkIfUserExistQuery);
					
                    if (empty($check)) {
                        $insertString = "INSERT INTO users(
							`username`,
							`password`,
							`email`,
							`birthday`
							) VALUE(
							'".$username."',
							'".md5($password)."',
							'".$email."',
							'".$birthday."'
							);";
							$db->query($insertString);
							$_SESSION["username"] = $username;
							header("location: list.php");
					}
                    else
                    {
                        echo "<script>window.location.href='index.php?error=userWxists'</script>";
                    }
                   
                }
            }
        }
    }
?>