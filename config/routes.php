<?php

return [
    /*  gallery controller  */
	'gallery/([0-9]+)' => 'gallery/post/$1',	//gallery/123 one photo
    'gallery/page/([0-9]+)' => 'gallery/list/$1',
	'gallery/([a-z]+)/([0-9, a-z]+)' => 'gallery/sortby/$1/$2',	//gallery/user/42 || gallery/category/4242
//	'gallery/([a-z]+)/([a-z]+)'	=>	'gallery/sortby/$1/$2',	//	 gallery/user/rudi || gallery/category/cats
    'gallery' => 'gallery/list',	// actionList in GalleryController	//all list of all users
    'posts/likes' => 'gallery/getPostsLikes',
    'post/setlike' => 'gallery/setLike',
//    'posts/comments' => 'gallery/getPostsComments',
    'posts/comment' => 'gallery/commentPost',
    'posts/delete' => 'gallery/deletePost',

    /*  profile controller  */
    'profile/([0-9])' => 'profile/user/$1',
    'profile/([0-9])/page/([0-9]+)' => 'profile/user/$1/$2',
    'settings' => 'profile/settings',  // id from session

    /*  login controller    */
	'login' => 'login/login',		// actionSignIn in LoginController
    'logout' => 'login/logout',
    'signup' => 'login/signup',
    'confirmation/([0-9, a-f]+)' => 'login/confirm/$1',
    'reset-password' => 'login/resetPassword',
    'create-new-password/([0-9, a-f]+)/([0-9, a-f]+)' => 'login/newPassword/$1/$2',

    /*  shot controller */
	'new' => 'shot/new'


	//'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2'
];
