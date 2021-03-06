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

		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {
// нужно заменить - ловит лишнее			
			if (preg_match("~$uriPattern~", $uri)) {

					$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
					
					$segments = explode('/', $internalRoute);

					$controllerName = array_shift($segments).'Controller';
					$controllerName = ucfirst($controllerName);


					$actionName = 'action'.ucfirst(array_shift($segments));

					$parameters = $segments;


				if (class_exists($controllerName)) {

                    $controllerObject = new $controllerName;
                    $result = call_user_func_array([$controllerObject, $actionName], $parameters);// так параметры передаются как отдельные переменные, а не как массив
                    if ($result != null){
                        exit;
                    }
				}
			}
		}
        $index = new GalleryController;
        $index->actionList();

	}



	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {

			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}
}
