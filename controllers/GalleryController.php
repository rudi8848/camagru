<?php

class GalleryController
{

	public function actionList()
	{
		$data = [];

		$picturesList = Gallery::getPicturesList();

		$data['posts'] = $picturesList;
		$data['title'] = 'Gallery';
		$view = new View();
		$view->render('index.php', $data);
//var_dump($data);exit;

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
        if (!empty($_POST['json'])){

            $postId = (array)json_decode($_POST['json']);
            \Gallery::setLike($postId['post']);
        }
        return true;
    }

}
