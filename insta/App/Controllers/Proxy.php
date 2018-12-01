<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Proxies;


class Proxy extends \Core\Controller
{
	
  public function activateAction() {
     
    $default_account = $this->account->getDefault($this->auth->isLoggedIn());
      
    if(isset($this->route_params['proxy'])) {

			if($this->account->setDefaultProxy($this->auth->isLoggedIn(), $default_account['id'], $this->route_params['proxy'])) {
						
				$this->redirect('/settings/proxy');
							
			}
		}	
  }

  public function checkAction() {
  	
  	$proxy = new Proxies();
  	
  	$proxies = $proxy->getNonVerifiedProxies();

		if(count($proxies) > 0) {
			
			$c_proxy = $proxies[0];
			
			if($this->check_proxy($c_proxy['proxy'])) {

				$proxy->updateProxyStat($c_proxy['id'], '1');
				
			} else {
				
				$proxy->updateProxyStat($c_proxy['id'], '-1');
				
			}
			
		}
		
  }


}
?>
