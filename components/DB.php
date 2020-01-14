<?php

class DB
{

	public static function getConnection()
	{
		$host = getenv('DB_HOST');
		$dbname = getenv('DB_NAME');
		$user = getenv('DB_USER');
		$password = getenv('DB_PASSWORD');

		$dsn = "mysql:host=$host;dbname=$dbname";

		//try {
			$db = new PDO($dsn, $user, $password);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("SET NAMES UTF8");
			return $db;
		//}
		//catch()

	}
}
