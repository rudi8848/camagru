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

            $q = 'SELECT to_post, COUNT(*) FROM likes WHERE to_post in ('.$ids.') GROUP by to_post';
            $res = $db->query($q, PDO::FETCH_ASSOC);

            $likes = $res->fetchAll();

            $response = [];
            foreach ($likes as $k => $v) {
                $response[$v['to_post']] = $v['COUNT(*)'];
            }
            echo json_encode($response);

        } catch (Exception $e) {

        }
    }

    public static function setLike(int $postId)
    {
        try {

            if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
            $db = DB::getConnection();

            $q = 'SELECT COUNT(*) FROM likes WHERE to_post = "'.$postId.'" AND author = "'.$_SESSION['user']['id'].'"';
            $result = $db->prepare($q);
            $result->execute();
            $likes = $result->fetchColumn();

            if ($likes == '0'){
                // set like in db
                $q = 'INSERT INTO likes (to_post, author) VALUES ("'.$postId.'", "'.$_SESSION['user']['id'].'")';
                $db->exec($q);

                echo json_encode(['inserted' => '1']);
                exit;
            } else {
                throw new Exception('Like is already set');

            }

        } catch (Exception $e) {
            echo json_encode(['inserted' => '0']);
            exit;
        }
    }

}
