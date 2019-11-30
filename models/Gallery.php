<?php

class Gallery
{

	public static function getPictureById($id)
	{
		# code...
	}


	public static function getPicturesList()
	{
		$host = 'localhost';
		$dbname = 'testcam';
		$user = 'root';
		$password = '';

		$db = DB::getConnection();

		$picturesList = [];

		$result = $db->query('SELECT *
			FROM posts ORDER BY created_at DESC LIMIT 10');

		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$picturesList [] = $row;
		}

		return $picturesList;
	}

	public static function getUserPictures($userId)
	{

	}

}
