<?php

include_once ROOT.'/models/Gallery.php';

class GalleryController
{
	
	public function actionList()
	{
		$picturesList = [];
		$picturesList = Gallery::getPicturesList();

		echo '<pre>';
		print_r($picturesList);
		echo '</pre>';


		return true;
	}


	public function actionView($category, $id)
	{
		echo '<br>'.$category;
		echo '<br>'.$id;
		return true;
	}
}