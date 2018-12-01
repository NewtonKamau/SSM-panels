<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;


/**
	Account Controller
**/

class Settings extends \Core\Controller
{

  public function indexAction() {
      
	  $user = $this->user->get_user_details($this->auth->isLoggedIn());
		$notif = '';
		
	  if(isset($this->route_params['token'])) {
	  	if($this->route_params['token'] == 'completeaccount') {
	  		$current = '';
				$notif = 'completeaccount';
	  	}
	  } else {
	  	$current = '';
	  }
      
      View::renderTemplate('Settings/index.php', [
          'user'	=>	$user,
          'notif'	=>	$notif,
          'current'	=>	$current
	  ]);
      
  }
  
	public function updateAction() {
		
		$account = new User($_POST);

		if($account->save()) {

			$this->redirect('/accounts/index');

		} else {
			
			View::renderTemplate('Settings/index.php', [
          'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
          'errors'	=>	$account->errors,
          'current'	=>	''
			]);

		}
		
	}
  
 	protected function before() {
		
	    if(!$this->auth->isLoggedIn()) {
	      
	      $this->redirect('/growth/login');
	      
	    }
	    
	}


}
?>
