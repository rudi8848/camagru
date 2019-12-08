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
}
