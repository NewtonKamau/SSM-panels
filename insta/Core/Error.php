<?php

namespace Core;

/**
	Error and Exception handler
**/

class Error
{
	
	/**
		*	Error handler. Convert all errors into Exceptions by throwing ErrorException.
		*
		*	@param int $level Error level
		*	@param string $message Error message
		*	@param string $file Filename the error was raised in
		*	@param int $line Line number in the file
	**/
	public static function errorHandler($level, $message, $file, $line) {
		if(error_reporting() !== 0) {
			throw new \ErrorException($message, 0, $level, $file, $line);
		}
	}
	
	/**
		* Exception Handler
	**/
	public static function exceptionHandler($exception) {
		
		//Code is 404 (Not found) or 500 (general error)
		$code = $exception->getCode();
		if($code != 404) {
			$code = 500;
		}
		http_response_code($code);
		
		if(\App\Config::SHOW_ERRORS) {
			echo "<h1>Fatal Error:</h1>";
			echo "<p>Uncaught Exception: '".get_class($exception)."'</p>";
			echo "<p>Message: '".$exception->getMessage()."'</p>";
			echo "<p>Stack Trace: <pre>'".$exception->getTraceAsString()."'</pre></p>";
			echo "<p>Thrown in: '".$exception->getFile()."' on line".$exception->getLine()." </p>";		
		} else {
			$log = dirname(__DIR__).'/logs/'.date('Y-m-d').'.txt';
			ini_set('error_log', $log);
			
			$message = "Uncaught Exception: '".get_class($exception)."'";
			$message .= "With message: '".$exception->getMessage()."'";
			$message .= "\nStack Trace: '".$exception->getTraceAsString();
			$message .= "\nThrown in: '".$exception->getFile()."' on line".$exception->getLine();
			
			error_log($message);
			// echo "<h1>An error occured</h1>";
			if($code == 404) {
				echo "<h1>Page not found</h1>";
			} else {
				echo "<h1>An error has occured</h1>";
			}
		}
	}
}

?>