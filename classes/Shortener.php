<?php
class Shortener
{  
	/*----------------------------------------------------------------------------
		Позволяет получить сокращенный URL для указанного оригинального URL
	----------------------------------------------------------------------------*/
	public static function getShortUrl($url, $userUrl = null)
	{
		$db = DB::getInstance();
		// Проверка правильности ввода пользователем сокращенного URL
		$validUserUrl = strlen($userUrl) == 6 
				&& preg_match("/[a-zA-Z\d]{6}/", $userUrl) 
				&& !self::shortUrlExist($userUrl);
		// Вернет false, если пользователь неправильно ввел сокращенный URL
		if ($userUrl !== null && !$validUserUrl) {
			return false;
		}
		try {
			$result = mysqli_query($db, "SELECT * FROM urls WHERE url = '$url'"); 
			if (!$result) {
				throw new Exception("Не удалось получить данные");
			} else {
				$row = mysqli_fetch_array($result);
				// Действия в случае присутствия оригинального URL в БД
				if (!empty($row['short_url'])) {
					// Если пользователь ввел сокращенный URL, то происходит замена
					// сокращенного URL на тот, что ввел пользователь. 
					// Возвращается пользовательский сокращенный URL или null,
					// если замена не удалась.					
					if ($validUserUrl) {
						return self::updateUrl($url, $userUrl) ? $userUrl : null;
					// Если пользователь не ввел сокращенный URL, то возвращается
					// сокращенный URl, извлеченный из БД.
					} else {
						return $row['short_url'];
					}
				// Действия в случае отсутствия оригинального URL в БД	
				} else {
					// Если пользователь ввел сокращенный URL, то происходит вставка
					// новой записи в БД, соспоставляющая оригинальному URL 
					// пользовательский сокращенный URL.
					// Возвращается пользовательский сокращенный URL или null,
					// если вставка не удалась.
					if ($validUserUrl) {
						$shortUrl = $userUrl;
					// Если пользователь не ввел сокращенный URL, то генерируется
					// новый URL (пока не будет получен тот, что еще не присутствет в БД).
					// Происходит вставка новой записи в БД, сопоставляющая 
					// оригинальному URL сгенерированный сокращенный URL.
					// Возвращается сгенерированный сокращенный URL или null, 
					// если вствка не удалась.
					} else {
						$shortUrl = self::makeShortUrl();
						while (self::shortUrlExist($shortUrl)) {
							$shortUrl = self::makeShortUrl();
						}
					}
					return self::insertNewUrl($url, $shortUrl) ? $shortUrl : null;
				}
			}
		} catch (Exception $e) {
			return null;
		}
	}

	/*----------------------------------------------------------------------------
		Создает рандомный сокращенный URL
	----------------------------------------------------------------------------*/
	private function makeShortUrl()
	{
		$randomSet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$shortPart = substr(str_shuffle($randomSet), 0, 6);    
		return $shortPart;
	}

	/*----------------------------------------------------------------------------
		Проверяет наличие в БД указанного сокращенного URL
	----------------------------------------------------------------------------*/
	private function shortUrlExist($shortUrl)
	{
		$db = DB::getInstance();
		try {
			$result = mysqli_query($db, "SELECT * FROM urls WHERE short_url = '$shortUrl'"); 
			if (!$result) {
				throw new Exception("Не удалось получить данные");
			} else {
				$row = mysqli_fetch_array($result);
				return !empty($row['short_url']);
			}
		} catch (Exception $e) {
			return false;
		}
	}

	/*----------------------------------------------------------------------------
		Добавляет в БД новую запись
	----------------------------------------------------------------------------*/
	private function insertNewUrl($url, $shortUrl)
	{
		$db = DB::getInstance();
		try {
			$result = mysqli_query($db, "INSERT INTO urls (url, short_url) VALUES ('$url', '$shortUrl')"); 
			if (!$result) {
				throw new Exception("Не удалось вставить строки");
			} else {	
				return true;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	/*----------------------------------------------------------------------------
		Обновляет сокращенный URL для указанного оригинального URL
	----------------------------------------------------------------------------*/
	private function updateUrl($url, $shortUrl)
	{
		$db = DB::getInstance();
		try {
			$result = mysqli_query($db, "UPDATE urls SET url = '$url', short_url = '$shortUrl' WHERE url = '$url'"); 
			if (!$result) {
				throw new Exception("Не удалось обновить строки");
			} else {	
				return true;
			}
		} catch (Exception $e) {
			return false;
		}
	}
}
