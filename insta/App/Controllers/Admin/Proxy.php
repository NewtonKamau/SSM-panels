<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\Proxies;


class Proxy extends \Core\Controller
{
    
  public function indexAction() {
  	
      $proxy = new Proxies();
      $proxies = $proxy->getProxies();
			
			View::renderTemplate('Admin/proxies.php', [
    	    'proxies' =>  $proxies,
    			'active' => 'proxies'
			]);
      
  }

  public function proxiesAction() {
      
    $proxy = new Proxies($_POST);
    
    if($proxy->addProxies()) {
        
        $this->redirect('/admin/proxy/index');
        
    }
	
  }

	protected function before() {
		if(!$this->auth->isAdminLoggedIn()) {
			$this->redirect('/admin/account/login');
		}
	}
	
}

?>