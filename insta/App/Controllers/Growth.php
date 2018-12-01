<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\User;

/**
	Account Controller
**/

class Growth extends \Core\Controller
{

	public function verifyemailAction() {
		
		$account = new User($_POST);

		if($account->setToken($this->auth->isLoggedIn())) {
			
			$account->sendActivationMail();
			
			echo 'success';
				
		}
	}

	public function signupAction() {

		if(isset($this->route_params['attribute'])) {

			if($this->route_params['attribute'] == 'success') {
				$success = 'Account has been created successfuly ! Please login to your account';
				View::renderTemplate('Users/signup.php', [
					'success'	=> $success
				]);
			}

		} else {

			if($this->auth->isLoggedIn()) {

				$this->redirect('/accounts/index');

			} else {

			View::renderTemplate('Users/signup.php');

			}

		}

	}

	public function loginAction() {
			
	    View::renderTemplate('Users/login.php', [
	    	'success'	=> isset($this->route_params['token']) && $this->route_params['token'] == 'success' ? 'true' : ''
	    ]);

	}

	public function signinAction() {

			$account = new User($_POST);
			$user	=	$account->authenticate();

			if($user) {

				$this->auth->login($user);
				if (!file_exists('user/'.md5($user->id))) {
				    mkdir('user/'.md5($user->id), 0777, true);
				}
				$this->redirect('/accounts/index');
				exit;

			} else {

				View::renderTemplate('Users/login.php', [
					'user'  => $account
		    ]);

			}


	}

	public function logoutAction() {

		$this->auth->logout();
		$this->redirect('/growth/login');
		exit;

	}
	
	public function activateAction() {
		
		$account = new User();
		
		if(isset($this->route_params['token'])) {
			
			if($account->activate($this->route_params['token'], $this->auth->isLoggedIn())) {
				
				if($this->auth->isLoggedIn()) {

					$this->redirect('/settings/index');
					
				} else {
					
					$this->redirect('/growth/login/activated');
					
				}
				
			}
			
		}
		
	}

	public function createAction() {


		$account = new User($_POST);

		if($account->saveNewUser()) {

			$this->redirect('/growth/login/success');

		} else {

			View::renderTemplate('Users/signup.php', [
				'user'  => $account
			]);

		}

	}

}
?>
