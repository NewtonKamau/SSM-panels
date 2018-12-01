<?php
namespace Core;

class Router
{
	/*
		Associative array of routes ( Routing Table)
	*/
	protected $routes = [];
	
	/*
		Parameters from the matched routes
	*/	
	protected $params = [];
	
	/*
		Match the root in to roots in the rooting table, setting the params property
		if the route is found
		$params = Parameters ( Controller, Action, ...)
	*/
	public function match($url) {
		// foreach($this->routes as $route => $params) {
			// if($url == $route) {
				// $this->params = $params;
				// return true;
			// }
		// }
		
		// $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
		
		foreach($this->routes as $route => $params) {
			if(preg_match($route, $url, $matches)) {
				// Get named capture groupe values
				// $params = [];
				
				foreach($matches as $key => $match) {
					if(is_string($key)) {
						$params[$key] = $match;
					}
				}
				
				$this->params = $params;
				return true;
			}
		}
		
		return false;
	}
	
	/*
		Add a root to the routing Table
		$route = the route URL
		$params = Parameters ( Controller, Action, ...)
	*/
	public function add($route, $params = []) {
		// Convert the root into regular expressions, escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);
		
		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
		
		// Convert variables with custom regex {id:\d+}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		
		// Add start and end delimiters, and case sensitive
		$route = '/^'	.	$route	.	'$/i';
		
		$this->routes[$route] = $params;
	}
	
	/*
		Get all the routes from the routing Table
	*/
	public function getRoutes() {
		return $this->routes;
	}

		/*
		Get all the routes from the routing Table
	*/
	public function getParams() {
		return $this->params;
	}
	
	public function dispatch($url) {
		$url = $this->removeQueryStringVariables($url);
		if($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			// $controller = "App\Controllers\\$controller";
			$controller = $this->getNamespace().$controller;
			
			if(class_exists($controller)) {
				$controller_object = new $controller($this->params);
				
				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);
				
			if(is_callable([$controller_object, $action])) {
					$controller_object->$action();
				} else {
					// echo "Method $action (in controller $controller) not found !";
					throw new \Exception("Method $action (in controller $controller) not found !");
				}
			} else {
				// echo "Controller class $controller not found";
				throw new \Exception("Controller class $controller not found");
			}
		} else {
			// echo "No route matched !";
			throw new \Exception("No route matched !", 404);
		}
	}
	
	/**
	* Convert the string with hyphens to StudlyCaps
	* eg : post-authors => PostAuthors
	**/
	
	protected function convertToStudlyCaps($string) {
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}
	
	/**
	* Convert the string with hyphens to camelCase
	* eg : add-new => addNew
	**/
	
	protected function convertToCamelCase($string) {
		return lcfirst($this->convertToStudlyCaps($string));
	}
	
	protected function removeQueryStringVariables($url) {
		if($url != '') {
			$parts = explode('&', $url, 2);
			if(strpos($parts[0], '=') === false) {
				$url = $parts[0];
			} else {
				$url = '';
			}
		}
		return $url;
	}
	
	/**
		* Get the namespace for the controller class. The namespace defined in the 
		* route parameters is added if present
	**/
	protected function getNamespace() {
		$namespace = 'App\Controllers\\';
		
		if(array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'].'\\';
		}
		
		return $namespace;
	}
}

?>