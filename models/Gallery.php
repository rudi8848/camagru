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

		$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

		$picturesList = [];

		$result = $db->query('SELECT id, title, date, content
			FROM posts ORDER BY date DESC LIMIT 10');

		while($row = $result->fetch()) {
			$picturesList[$i]['id'] = $row['id'];
			$picturesList[$i]['title'] = $row['title'];
			$picturesList[$i]['date'] = $row['date'];
			$picturesList[$i]['content'] = $row['content'];
			$i++;
		}

		return $picturesList;
	}

	public static function getUserPictures($userId)
	{

	}

}