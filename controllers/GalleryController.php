<?php

include_once ROOT.'/models/Gallery.php';

class GalleryController
{
	
	public function actionList()
	{
	    echo __CLASS__.'::'.__METHOD__.'<br/>';
//		$picturesList = [];
//		$picturesList = Gallery::getPicturesList();
//
//		echo '<pre>';
//		print_r($picturesList);
//		echo '</pre>';


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