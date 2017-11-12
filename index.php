<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  			<script src="form.js"></script>
			<style>
				form, .result {
					width: 600px;
					margin: 40px auto 0 auto;
				}
			</style>
		</head>
		<body>
			<div class="container">
				<form id="form" action="" method="POST">
					<div class="form-group">
						<label>Исходный URL</label>
						<input type="url" class="form-control" name="url" placeholder="http://example.com" required>
					</div>
					<div class="form-group">
						<label>Сокращенный URL</label>
						<input type="text" class="form-control" name="userUrl" minlength="6" maxlength="6">
					</div>
					<div class="form-group">
						<button id="submit" class="btn btn-primary" name="submit">Отправить</button>
					</div>
				</form>
				<div id="result" class="result"></div>
			</div>
		</body>
	</html>