<?php
include_once("../classes/DB.php");
include_once("../classes/Shortener.php");

/*-----------------------------------------------------------------------------
	Обработчик формы
-----------------------------------------------------------------------------*/
if (!empty($_POST['url'])) {      
	$site = "http://test2-alenkaololenka308345.codeanyapp.com/PigarevaAlena/";
	$url = $_POST['url'];  
	if (!empty($_POST['userUrl'])) {
		$shortPart = Shortener::getShortUrl($url, $_POST['userUrl']);
	} else {
		$shortPart = Shortener::getShortUrl($url);
	}
	$result = array('shortPart' => $shortPart, 'site' => $site);
	echo(json_encode($result));	
}
