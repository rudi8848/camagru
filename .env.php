<?php

$variables = [
	'DB_NAME' => 'testcam',
	'DB_USER' => 'root',
	'DB_PASSWORD' => '',
	'DB_HOST' => '127.0.0.1',
    'ADMIN_EMAIL' => 'anna.v8848@gmail.com',
    'SERVER_NAME' => 'https://camagru.com'
	];

foreach ($variables as $key => $value) {
	putenv("$key=$value");
}
