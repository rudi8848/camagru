<?php
try {
require_once('config/setup.php');
require_once('.env.php');
//FRONT CONTROLLER

// 1. общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
session_start();
require_once(ROOT . '/components/Autoload.php');

$router = new Router();
$router->run();
}
catch (Exception $e) {
  die ($e->getMessage());
}


/*


//phpinfo();
echo '<h1>camagru</h1>';

try {

	require_once('config/setup.php');
	$db->exec($q);
	$query = 'show tables;';
	$ret = $db->query($query);

	echo '<ol>';
	while($table = $ret->fetch()){
		echo '<li>'.$table['Tables_in_testcam'];
		$subq = 'show columns from '.$table['Tables_in_testcam'];
		echo '<ul>';
		$columns = $db->query($subq);
		$col = $columns->fetchAll();
		foreach($col as $c) {
			echo '<li>'.$c['Field'].'</li>';
		}

		echo '</ul>';
		echo '</li>';
	}
	echo '</ol>';
}
catch(Exception $e)
{
	echo $e->getMessage();
}
*/
