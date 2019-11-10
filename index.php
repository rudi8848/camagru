<?php
//phpinfo();
echo 'camagru'.PHP_EOL;

try {

	require_once('config/setup.php');


	//$query = 'select version() as version';
$query = 'show tables';
	$ver = $db->query($query);

	$version = $ver->fetch();

	echo $version['version'];
}
catch(Exception $e)
{
	echo $e->getMessage();
}
