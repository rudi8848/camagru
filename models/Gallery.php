<?php

class Gallery
{

    const POST_PER_PAGE = 10;


	public static function getPictureById($id)
	{
		# code...
	}


	public static function getPicturesList(int $page, int $userId = 0)
	{

		$db = DB::getConnection();

		$picturesList = [];

		$result = $db->query('SELECT *
			FROM posts 
			JOIN users on posts.author=users.user_id WHERE posts.is_deleted = 0 '. ($userId > 0 ? " AND user_id = $userId " : "") .
            ' ORDER BY created_at DESC LIMIT '.$page * self::POST_PER_PAGE.', '.self::POST_PER_PAGE);

		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$picturesList [] = $row;
		}

		return $picturesList;
	}

	public static function getPagesTotalNumber(int $userId = 0)
    {
        $db = DB::getConnection();

        $q = 'SELECT COUNT(*)  FROM posts WHERE is_deleted=0'.($userId > 0 ? " AND author = $userId " : "");
        $result = $db->prepare($q);
        $result->execute();
        return  ceil((int)$result->fetchColumn() / self::POST_PER_PAGE);
    }

	public static function getUserPictures($userId)
	{

	}

	public static function getPostsLikes(array $postId)
    {
        try {

            $db = DB::getConnection();

            $ids = implode(',', $postId);

            $q = 'SELECT to_post, COUNT(*) likescount FROM likes WHERE to_post in ('.$ids.') GROUP by to_post';
            $res = $db->query($q, PDO::FETCH_ASSOC);

            $likes = $res->fetchAll();

            $response = [];
            foreach ($likes as $k => $v) {
                $response[$v['to_post']] = $v['likescount'];
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

            $q = 'SELECT COUNT(*) FROM likes WHERE to_post = :postId AND author = :userId';
            $result = $db->prepare($q);
            $result->execute(['postId' => $postId,
                'userId' => (int)$_SESSION['user']['id']]);
            $likes = $result->fetchColumn();

            if ($likes == '0'){

                $params = [
                    'post' => $postId,
                    'author' => (int)$_SESSION['user']['id']
                ];
                $q = $db->prepare('INSERT INTO likes (to_post, author) VALUES (:post, :author)');
                $q->execute($params);

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


    public static function getPostsComments(array $posts)
    {

        $comments = [];
        $db = DB::getConnection();

        $ids = implode(',', $posts);

        $q = 'SELECT users.username, users.pic, comments.* FROM comments 
                JOIN users on users.user_id = comments.author  
                WHERE to_post in ('.$ids.')  order by created_at';

        $res = $db->query($q, PDO::FETCH_ASSOC);
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $comments [] = $row;
        }
        $response = [];
        foreach ($comments as $k => $v) {
            $response[$v['to_post']][] = $v;
        }
        return $response;
    }

    public static function commentPost(array $data) : void
    {
        try {

            if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');

            $db = DB::getConnection();

            $date = new DateTime('now');

            $query = $db->prepare('INSERT INTO comments (to_post, content, author) VALUES (:post, :content, :id)');
            $params = [
                'post' => (int)trim($data['post']),
                'content' => htmlspecialchars(trim($data['content'])),
                'id' => (int)$_SESSION['user']['id']
            ];
            $query->execute($params);

            $post = $db->prepare("SELECT author FROM posts WHERE post_id = :post");
            $post->execute(['post' => (int)trim($data['post'])]);
            $authorId = $post->fetchColumn();

            $authorInfo = $db->query("SELECT username, email, notifications FROM users WHERE user_id=$authorId");
            $authorContacts = $authorInfo->fetch(PDO::FETCH_ASSOC);

            if ($authorContacts['notifications'] == 1) {

                $msg = "<p>Hello, {$authorContacts['username']}!</p>
                <p>{$_SESSION['user']['name']} left new comment to your photo, <a href='".getenv('SERVER_NAME')."'>check it out!</a></p>
                <q style='font-style: italic'>{$params['content']}</q>";

                Helper::sendEmail($authorContacts['email'], "New comment", $msg);
            }

            echo json_encode(['content' => $data['content'],
                'author' => $_SESSION['user']['name'],
                'pic' => $_SESSION['user']['pic'],
                'id' => $_SESSION['user']['id'],
                'date' => $date->format('d.m.Y H:i')]);
        } catch (Exception $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }


    public static function  deletePost()
    {

        try {
            if (empty($_POST['post'])) throw new Exception('No post specified');
            if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');

            $postId = (int)$_POST['post'];

            $db = DB::getConnection();
            $post = $db->query("SELECT * FROM posts where post_id=$postId", PDO::FETCH_ASSOC);
            $postData = $post->fetch();
            if (empty($postData)) throw new Exception("No such post");
            if ($postData['author'] != $_SESSION['user']['id']) throw new Exception('Not authorized');

            $res = $db->exec("UPDATE posts SET is_deleted=1, deleted_at=NOW(), deleted_by={$_SESSION['user']['id']} WHERE post_id=$postId");
            if ($res == 1) {
                echo json_encode(['error' => false, 'message' => 'success']);
            }
        } catch (Exception $e){

            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

}
