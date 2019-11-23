<?php

require_once('config/setup.php');
require_once('.env.php');
//FRONT CONTROLLER

// 1. общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);


// 2. подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Router.php');


//	3. установка соединения с БД
require_once(ROOT.'/DB.php');


//	4. вызов роутера
$router = new Router();
$router->run();



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
