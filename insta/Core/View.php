<?php
namespace Core;

class View
{

	/*
		Render a view file
	*/	
	public static function render($view, $args = []) {
		
		extract($args, EXTR_SKIP);
		$file = "../App/Views/$view";
		if(is_readable($file)) {
			require $file;
		} else {
			// echo "$file not found";
			throw new \Exception("$file not found");
		}
	}
	
	public static function renderTemplate($view, $args = []) {
		static $twig = null;

		if($twig === null) {
			
			$auth = new \App\Auth;
			$user = new \App\Models\User();
			
			$json_decode_filter = new \Twig_Filter('json_decode', function ($array) {
			    return json_decode($array);
			});
			
			$loader = new \Twig_Loader_Filesystem('../App/Views');
			$twig = new \Twig_Environment($loader);
			$twig->addGlobal('site_path', \App\Config::SITE_PATH);
			$twig->addFilter($json_decode_filter);
			
			if($auth->isLoggedIn()) {
				$twig->addGlobal('is_logged_in', $auth->isLoggedIn());
				$twig->addGlobal('get_user_details', $user->get_user_details($auth->isLoggedIn()));
				$twig->addGlobal('admin_logged_in', $auth->isAdminLoggedIn());
			}
		}

		echo $twig->render($view, $args);
	}
	

}

?>