<?php
include("../classes/DB.php");

/*-----------------------------------------------------------------------------
	Выполняет перенаправление с сокращенного URL на оригинальный
-----------------------------------------------------------------------------*/
$redirect = $_GET["r"];
$db = DB::getInstance();
$result = mysqli_query($db, "SELECT * FROM urls WHERE short_url = '$redirect'");
if ($result) {
	$row = mysqli_fetch_array($result);
	header("Location: " . $row['url']);
} else {
	header("HTTP/1.0 404 Not Found");
echo("Страницы не существует");
}
