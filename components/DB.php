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
		$db = new PDO($dsn, $user, $password);

		return $db;
	}
}