<?php

class Gallery
{

	public static function getPictureById($id)
	{
		# code...
	}


	public static function getPicturesList(int $userId = 0)
	{
		$host = 'localhost';
		$dbname = 'testcam';
		$user = 'root';
		$password = '';

		$db = DB::getConnection();

		$picturesList = [];

		$result = $db->query('SELECT *
			FROM posts 
			JOIN users on posts.author=users.user_id '. ($userId > 0 ? " WHERE user_id = $userId " : "").
			'ORDER BY created_at DESC LIMIT 10');

		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$picturesList [] = $row;
		}

		return $picturesList;
	}

	public static function getUserPictures($userId)
	{

	}

}
