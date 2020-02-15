<?php

class GalleryController
{

	public function actionList()
	{
		$data = [];

		$page = 0;

		$args = func_get_args();

		if (!empty($args)){

		    $page = (int)$args[0];
		    if ($page > 0) $page -= 1;
		    $page = abs($page);
		}
        $totalPages = Gallery::getPagesTotalNumber();

        if ($page > ( $totalPages - 1 )) $page = 0;

		$picturesList = Gallery::getPicturesList($page);

		$comments  = [];

		foreach ($picturesList as $post) {
		    $comments[] = $post['post_id'];

        }

        $data['comments'] = Gallery::getPostsComments($comments);

        $data['posts'] = $picturesList;
		$data['title'] = 'Gallery';
		$data['currentPage'] = $page + 1;
        $data['totalPages'] = $totalPages;
		$view = new View();
		$view->render('index.php', $data);

		return true;
	}


	public function actionSortby($category, $id)
	{
        echo __CLASS__.'::'.__METHOD__.'<br/>';
//		echo '<br>'.$category;
//		echo '<br>'.$id;
		return true;
	}


	public function actionPost($postId)
    {
        echo __CLASS__.'::'.__METHOD__.'<br/>';
        return true;
    }

    public function actionGetPostsLikes()
    {

        if (!empty($_POST['json'])){

            $ids = (array)json_decode($_POST['json']);
            \Gallery::getPostsLikes($ids);
        }
        return true;
    }

    public function actionSetLike()
    {
        try {
            if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
            if (!empty($_POST['json'])) {

                $postId = (array)json_decode($_POST['json']);
                \Gallery::setLike($postId['post']);
            }
        } catch (Exception $e)
        {
            echo json_encode(['inserted' => '0']);
            exit;
        }
        return true;
    }


    public static function actionCommentPost()
    {
        try {
            if (!empty($_POST)) {

                $data['content'] = $_POST['comment'];

                $data['post'] = (int)$_POST['post'];

                if (empty($data['content']) || empty($data['post'])) {
                    return false;
                }

                if (empty($_SESSION['user']['id']) || Profile::isValid() == false) throw new Exception('Not authorized');
                Gallery::commentPost($data);
            }
        }catch (Exception $e){

            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
        return true;
    }


    public static function actionDeletePost()
    {

        try {
            if (empty($_SESSION['user']['id']) || Profile::isValid() == false) throw new Exception('Not authorized');
            if (!empty($_POST)) {

                Gallery::deletePost();
            }
        } catch (Exception $e) {

            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
        return true;
    }

}
