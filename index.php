<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
			<style>
				form, .result {
					width: 600px;
					margin: 40px auto 0 auto;
				}
			</style>
		</head>
		<body>
			<div class="container">
				<form action="" method="POST">
					<div class="form-group">
						<label>Исходный URL</label>
						<input type="url" class="form-control" name="url" placeholder="http://example.com" required>
					</div>
					<div class="form-group">
						<label>Сокращенный URL</label>
						<input type="text" class="form-control" name="userUrl" minlength="6" maxlength="6">
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="submit">
					</div>
				</form>

<?php
include_once("classes/DB.php");
include_once("classes/Shortener.php");

if (!empty($_POST['submit'])) {      
	$site = "http://test2-alenkaololenka308345.codeanyapp.com/PigarevaAlena/";
	$url = $_POST['url'];  
	if (!empty($_POST['userUrl'])) {
		$shortPart = Shortener::getShortUrl($url, $_POST['userUrl']);
	} else {
		$shortPart = Shortener::getShortUrl($url);
	}
	if ($shortPart) {
		echo("<div class=\"result\"><a href='$site$shortPart' target='_blank'>$site$shortPart</a></div>");
	} elseif ($shortPart === null) {
		echo("<div class=\"result\">Не удалось сгенерировать URL.</div>");
	} else {
		echo("<div class=\"result\">");
		echo("Неверный сокращенный URL.<br>");
		echo("Проверьте правильность ввода. ");
		echo("Сокращенный URL должен состоять из 6 букв латинского алфавита в любом регистре и/или цифр.<br>");
		echo("Если все верно, то, возможно, такой URL уже существует. </div>");
	}
}
?>

	</div>
</body>
</html>
