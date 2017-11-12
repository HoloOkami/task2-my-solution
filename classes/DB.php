<?php
class DB
{
	public static $instance;	

	/*----------------------------------------------------------------------------
		Создает/возвращает экземпляр базы данных
	----------------------------------------------------------------------------*/
	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = mysqli_connect('127.0.0.1', 'root', '');
			mysqli_select_db(self::$instance, 'shortener');
			mysqli_query(self::$instance, "set names 'utf8'");
			date_default_timezone_set('Europe/Moscow');
		} 
		return self::$instance;
	}
}
