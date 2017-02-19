<?php


class Route
{
	public static $language = 'eng'; // язык сайта
	public static $first = 'main'; // контроллер
	public static $second = 'index'; // действие
	
	public static $backPage = 'main/index'; // ссылка на предыдущую страницу

	public static $baseUrl; // путь к главному скрипту (index.php), без домена и не включая index.php
	private static function baseUrl() {
		$baseUrl = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
		return $baseUrl;
	}	
	
	static function start() {
		
		$args1 = explode('/',$_SERVER['SCRIPT_NAME']); // получаем путь до главного скрипта (index.php)
		$routes = explode('/',$_SERVER['REQUEST_URI']); // получаем полный путь URI

        // вырезаем все, что до (index.php)
		for($i = 0, $size = count($args1); $i < $size; ++$i) {
			if($args1[$i] == $routes[0]) array_shift($routes);
		}
		//теперь $routes[] содержит параметры: 1 - определяет язык, 2 - контроллер, 3 - действие
		
		if(!empty($routes[0])) {	
			Route::$language = $routes[0];
		}
		
		if(!empty($routes[1])) {
			Route::$first = $routes[1];
		}
		
		if(!empty($routes[2])) {
			Route::$second = $routes[2];
		}
		
		Route::$baseUrl = Route::baseUrl();

		if(Route::$language == 'eng' || Route::$language == 'ru') { }
        else { Route::ErrorPage404(); }

		$controller_name = 'Controller_'.Route::$first;
		$action_name = 'action_'.Route::$second;

		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "app/controllers/".$controller_file;
		if(file_exists($controller_path)) {
			include "app/controllers/".$controller_file;
		}
		else { Route::ErrorPage404(); }
		
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action)) {
			$controller->$action();
		}
		else { Route::ErrorPage404(); }
		
	}

	static function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
		exit();
    }
    
}
