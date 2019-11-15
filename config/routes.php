<?php

return [

	'gallery/([0-9]+)' => 'gallery/view',	//gallery/view/123 one photo
	'gallery/([a-z]+)/([0-9]+)' => 'gallery/view/$1/$2',	//gallery/view/cats/42 sort by category
									//	? gallery/user/432	// all user photos
	'gallery' => 'gallery/list',	// actionList in GalleryController	//all list of all users
	'login' => 'login/signin',		// actionSignIn in LoginController
	'shot' => 'shot/new'


	//'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2'
];