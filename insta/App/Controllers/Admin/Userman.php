<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\User;


class Userman extends \Core\Controller
{

	protected function before() {
		if(!$this->auth->isAdminLoggedIn()) {
			$this->redirect('/admin/account/login');
		}
	}

	public function showAction() {

			$users = new User();

			View::renderTemplate('Admin/users.php', [
				'success'	=>	(isset($this->route_params['attribute']) ? "Informations has been edited successfuly !" : ""),
				'users'	=>	$users->getAll()
			]);

	}
	
	public function loadaccountAction() {
		
		$load_account = $this->user->get_user_details($_POST['accid']);
		$insta_accounts = $this->account->getAll($load_account['id']);

		View::renderTemplate('Admin/Forms/account.php', [
			'details' => $load_account,
			'accounts' => $insta_accounts
		]);
		
	}
	
	public function editAction() {
		
			$users = new User();

			if($users->update_user_infos($_POST)) {
				$this->success[] = 'Informations has been edited successfuly !';

				$this->redirect('/admin/users/show/success');
			}
	
	
		}
		
	public function deleteAction() {
		
		$user = new User();
		
		if(isset($this->route_params['id'])) {
			
			$user->delete_user($this->route_params['id']);		
			
		}
			
		$this->redirect('/admin/users/show');
		
	}

}
?>
