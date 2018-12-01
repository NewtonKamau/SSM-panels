<?php
set_time_limit(0);
date_default_timezone_set("Pacific/Pago_Pago");

// Front Controller
//echo 'requested URL "'	.	$_SERVER['QUERY_STRING']	.	'"';

require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/vendor/simple_html_dom.php';
require_once dirname(__DIR__).'/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
/**
Autoloader
**/
spl_autoload_register(function($class) {
	$root = dirname(__DIR__);
	$file = $root.'/'.str_replace('\\', '/', $class).'.php';
	if(is_readable($file)) {
		require $root.'/'.str_replace('\\', '/', $class).'.php';
	}
});

/**
	Error and Exception handling
**/
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

/**
Rooting
**/
$router = new Core\Router();

//Add routes
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('{controller}/{action}/{token:\w+}');
$router->add('{controller}/{action}/{attribute}/{parameter:[^/]+}');
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{attribute}');
$router->add('{controller}/{action}/{id:\d+}');
$router->add('{controller}/{action}/{proxy:[^a-z]+}');


$router->dispatch($_SERVER['QUERY_STRING']);

?>
