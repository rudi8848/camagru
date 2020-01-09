<?php

class Gallery
{

	public static function getPictureById($id)
	{
		# code...
	}


	public static function getPicturesList(int $userId = 0)
	{

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

	public static function getPostsLikes(array $postId)
    {
        try {

            $db = DB::getConnection();


            $ids = implode(',', $postId);
//            var_dump($ids);exit;
            $q = 'SELECT to_post, COUNT(*) FROM likes WHERE to_post in ('.$ids.') GROUP by to_post';
            $res = $db->query($q, PDO::FETCH_ASSOC);

            $likes = $res->fetchAll();
//            print_r($likes);
            $response = [];
            foreach ($likes as $k => $v) {
                $response[$v['to_post']] = $v['COUNT(*)'];
            }
            echo json_encode($response);
//            print_r($response);
        } catch (Exception $e) {

        }
    }

}
