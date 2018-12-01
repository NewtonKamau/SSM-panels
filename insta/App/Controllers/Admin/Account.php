<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\User;

class Account extends \Core\Controller
{

	public function loginAction() {
		View::renderTemplate('Admin/login.php');
	}

	public function authenticateAction() {
		$account = new User($_POST);
		$admin	=	$account->authenticateAdmin();

		if($admin) {

			$this->auth->loginAdmin($admin);
			$this->redirect('/admin/userman/show');
			exit;

		} else {

			View::renderTemplate('Admin/login.php', [
				'admin'  => $account
			]);

		}
	}

	public function logoutAction() {

		$this->auth->logout();

		$this->redirect('/admin/account/login');

		exit;

	}

}
?>
