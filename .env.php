<?php

$variables = [
	'DB_NAME' => 'testcam',
	'DB_USER' => 'root',
	'DB_PASSWORD' => 'root',
	'DB_HOST' => '127.0.0.1'
	];

foreach ($variables as $key => $value) {
	putenv("$key=$value");
}
