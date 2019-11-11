<?php

class Router
{

	private $routes;

	
	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}


	public function run()
	{
		// получить строку запроса
		$uri = $this->getURI();

		// проверить наличие такого запроса в routes.php
		// если есть совпадение - определить контроллер и экшн
		foreach ($this->routes as $uriPattern => $path) {
// нужно заменить - ловит лишнее			
			if (preg_match("~$uriPattern~", $uri)) {
					$segments = explode('/', $path);

					$controllerName = array_shift($segments).'Controller';
					$controllerName = ucfirst($controllerName);


					$actionName = 'action'.ucfirst(array_shift($segments));

				

				// подключить файл класса-контроллера
				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';// add try catch
				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}

				// создать объект, вызвать метод (экшн)
				$controllerObject = new $controllerName;
				$result = $controllerObject->$actionName();
				if ($result != null){
					break;
				}
			}
		}


	}



	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {

			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}
}