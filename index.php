<?php
//phpinfo();
echo 'camagru';

try {

	require_once('config/setup.php');


	$query = 'select version() as version';

	$ver = $db->query($query);

	$version = $ver->fetch();

	echo $version['version'];
}
catch(Exception $e)
{
	echo $e->getMessage();
}