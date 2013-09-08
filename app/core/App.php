<?php
namespace PinIB;

class App{
	public static $patterns = array(
		':any' => '[^/]+',
		':num' => '[0-9]+',
		':all' => '.*'
	);

	public function __construct($view, $routes){
		$this->view = $view;
		$this->routes = $routes;
	}

	public function run(){
		$uri = $_SERVER['REQUEST_URI'];
		
		$params = array();
		
		if(array_key_exists($uri, $this->routes)){
			return $this->route($this->routes[$uri]);
		}
		
		$searches = array_keys(self::$patterns);
		$replaces = array_values(self::$patterns);
		
		$numRoutes = count($this->routes);
		$i = 0;
		foreach($this->routes as $pattern => $action){		
			if(strpos($pattern, ':') !== false) {
				$pattern = str_replace($searches, $replaces, $pattern);
			}
			
			if(preg_match('#^' . $pattern. '$#', $uri, $matches)){
				if(isset($matches[0])){
					$controller = $action;
				}else{
					$controller = 'index';
				}
				
				if(isset($matches[1])){
					$method = $matches[1];
				}else{
					$method = 'index';
				}
				
				$params = array_slice($matches, 1);
				
				$this->route($controller, $method, $params);
			}else{
				if($i == $numRoutes-1){
					$this->route('FourOhFour');
				}
			}
			$i++;
		}
	}
	
	public function route($controller, $method = '', $params = array()){
		if(!isset($controller)){
			$controller = 'FourOhFour';
		}
		
		if(!isset($method)){
			$method = 'index';
		}
		
		$className = 'PinIB\\Controllers\\' . ucfirst($controller);
		if(!class_exists($className)){
			$className = 'PinIB\\Controllers\\FourOhFour';
		}

		$controller = new $className($this);

		if(method_exists($className, $method) && is_callable(array($className, $method))){
			call_user_func_array(array($controller, $method), $params);
		}else{
			call_user_func_array(array($controller, 'index'), $params);
		}	
	}
	
	public function autoload($className){
		preg_match('/([^\\\]+)$/', ltrim($className, '\\'), $match);
		$file = PINIB_PATH . '/app/controllers/' . $match[0] . '.php';
		if(file_exists($file)){
			require $file;
		}
	}
	
	public function getModel($modelName){
		if(file_exists(PINIB_PATH . '/app/models/' . $modelName . '.php')){
			require PINIB_PATH . '/app/models/' . $modelName . '.php';
		}
		$modelName = '\\PinIB\\Models\\' . ucfirst($modelName);
		return new $modelName($this);
	}
}
class Exception extends \Exception{}