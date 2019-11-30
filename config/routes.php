<?php

return [
    /*  gallery controller  */
	'gallery/([0-9]+)' => 'gallery/post/$1',	//gallery/123 one photo
	'gallery/([a-z]+)/([0-9, a-z]+)' => 'gallery/sortby/$1/$2',	//gallery/user/42 || gallery/category/4242
//	'gallery/([a-z]+)/([a-z]+)'	=>	'gallery/sortby/$1/$2',	//	 gallery/user/rudi || gallery/category/cats
	'gallery' => 'gallery/list',	// actionList in GalleryController	//all list of all users

    /*  profile controller  */
    'profile/([0-9])' => 'profile/user/$1',
    'settings' => 'profile/settings',  // id from session

    /*  login controller    */
	'login' => 'login/login',		// actionSignIn in LoginController
    'logout' => 'login/logout',
    'signup' => 'login/signup',

    /*  shot controller */
	'new' => 'shot/new'


	//'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2'
];
