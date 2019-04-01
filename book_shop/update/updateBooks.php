<?php 
	session_start();
	if(isset($_GET["bookid"])){
		require_once "../db.php";
		$db = db::get();
		$id = $db->escape($_GET["bookid"]);

		$selectBookQuery = "SELECT * FROM book WHERE book_id=".$id;
		$books = $db->getArray($selectBookQuery);
		
		$selectWritersQuery = "SELECT * FROM writer";
		$allWriter = $db->getArray($selectWritersQuery);
		
		$selectCategoriesQuery = "SELECT * FROM category";
		$allCategory = $db->getArray($selectCategoriesQuery);
 
		$selectlanguageQuery = "SELECT * FROM languages";
		$alllanguages = $db->getArray($selectlanguageQuery);
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
					<li class="nav-item  active">
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
		<?php if(count($books) < 1): ?>
			<div class="container">
				<div class="btn btn-danger">Ez a könyv nem létezik.</div>
			</div>
		<?php endif; ?>
		<?php if(count($books) > 0): ?>
			<?php foreach($books as $book): ?>
				<div class="container text-center">
					<img src="../image/<?php echo $book['cover_image']; ?>" class="text-center" alt="Borito kepe" style="border-radius: 50%; height: 25vh; width: 25vw;">
				<form class="container form-group" action="updateBookData.php?bookid=<?php echo $book['book_id']; ?>" method="post" enctype="multipart/form-data">
					
					<div class="form-row">
						<label for="book_title">Cím:</label>
						<input type="text" class="input form-control" name="book_title" id="book_title" required="true"  value="<?php echo $book['book_title']; ?>">
					</div>
					
					<div class="form-row">
						<label for="category_id">Műfaj:</label>
						<select class="input form-control" name="category_id" id="category_id">
                            <?php foreach($allCategory as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category["genre"]; ?></option>
                            <?php endforeach; ?>
						</select>
					 </div>
					 
					 <div class="form-row">
						<label for="publishing">Megjelenési dátum:</label>
						<input type="date" class="input form-control" name="publishing" id="publishing" value="<?php echo $book['publishing']; ?>">
					</div>
					
					<div class="form-row">
						<label for="language_id">Nyelv:</label>
						<select class="input form-control" name="language_id" id="language_id">
							<?php foreach($alllanguages as $languages): ?>
								<option value="<?php echo $languages['id']; ?>"><?php echo $languages["language"]; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					<div class="form-row">
						<label for="lid">Borító:</label>
						<select class="input form-control" name="lid" id="lid">
							<option value="Keményfedeles">Keményfedeles</option>
							<option value="Puha fedeles">Puha fedeles</option>
						<select>
					</div>
							
					<div class="form-row">
						<label for="quantity">Mennyiség:</label>
						<input type="number" class="input form-control" min="0" name="quantity" id="quantity" required="true"  value="<?php echo $book['quantity']; ?>">
					</div>
					
					<div class="form-row">
						<label for="story">Történet:</label>
						<input type="text"class="input form-control" name="story" id="story" required="true"  value="<?php echo $book['story']; ?>">
					</div>
					
					<div class="form-row">
						<label for="writer_id">Író:</label>
						<select name="writer_id" class="input form-control" id="writer_id">
                            <?php foreach($allWriter as $writer): ?>
                                <option value="<?php echo $writer['id']; ?>"><?php echo $writer["writer_name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
					</div>
					
					<button name="updateBook" class="btn btn-success">Adatok szerkesztése</button>
				</form>
				<form class="container form-group text-center" method="post" action="updateBook.php?bookid=<?php echo $book['book_id']; ?>" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleFormControlFile1">Képcsere:</label>
								<input type="file" class="form-control-file" name="fileToUpload2" id="exampleFormControlFile1" style="margin-left: 40%;">
								<button class="btn btn-success" name="uploadPicture">Kép frissítés</button>
							</div>
						</form>
				</div>
				
			<?php endforeach; ?>
		<?php endif; ?>
	</body>
	</html>
