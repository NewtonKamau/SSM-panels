<?php

namespace App\Controllers;

use \Core\View;
use \App\Config;
use \App\Models\Proxies;


class Accounts extends \Core\Controller
{

	protected $errors = [];

	protected $success = [];

	public function indexAction() {
		
		View::renderTemplate('Accounts/indexx.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$this->account->getAll($this->auth->isLoggedIn()),
			'notification' => (isset($this->route_params['token']) ? $this->route_params['token'] : ''),
			'errors'	=>	$this->errors
		]);

	}
	
	public function newAction() {

		View::renderTemplate('Accounts/new.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$this->account->getAll($this->auth->isLoggedIn()),
			'notification' => (isset($this->route_params['token']) ? $this->route_params['token'] : ''),
			'errors'	=>	$this->errors
		]);
		
	}
	
	public function likesAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		
		View::renderTemplate('Accounts/likes'.$this->route_params['token'].'.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function commentsAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		
		View::renderTemplate('Accounts/comments.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function followsAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		View::renderTemplate('Accounts/follows'.$this->route_params['token'].'.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function unfollowsAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		
		View::renderTemplate('Accounts/unfollows.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function directAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		
		View::renderTemplate('Accounts/messages.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function postAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());
		$user_details = $this->user->get_user_details($this->auth->isLoggedIn());
		if (!file_exists('user/'.md5($this->auth->isLoggedIn()))) {
		    mkdir('user/'.md5($this->auth->isLoggedIn()), 0777, true);
		}
		$dir = new \DirectoryIterator("user/".md5($this->auth->isLoggedIn()));
		foreach ($dir as $fileinfo) {
		    if (!$fileinfo->isDot() && !preg_match('/resize/', $fileinfo->getFilename())) {
		        $medias[] = $fileinfo->getFilename();
		    }
		}
		
		$t_offset = floatval($user_details['user_timezone']);
		$ammount = 11 + $t_offset;
		
		View::renderTemplate('Accounts/post.php', [
			'user'	=>	$user_details,
			'medias'	=>	(!empty($medias)) ? json_encode($medias) : '',
			'user_folder'	=>	"user/".md5($this->auth->isLoggedIn()),
			'current_time'	=>	date("Y-m-d H:i:s", strtotime($ammount." hours")),
			'accounts'	=>	$n_accounts
		]);		
		
	}
	
	public function uploadAction() {
		
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());
		if(is_array($_FILES))   
		 {
			$name = $_FILES['file']['name'];
			$file_name = explode(".", $name);  
			$allowed_ext = array("jpg", "jpeg", "mp4");
			
			$dirtargetPath = "user/".md5($this->auth->isLoggedIn()) . "/";
			if (!file_exists($dirtargetPath)) {
			    mkdir("user/".md5($this->auth->isLoggedIn()), 0777);
			}
			
			if(in_array(strtolower($file_name[1]), $allowed_ext))  
			{
				
				$rand_file = md5(rand());
				$new_name = $rand_file . '.' . $file_name[1];
				$uploadedMedias[] = $new_name;
				$sourcePath = $_FILES['file']['tmp_name'];  
				$targetPath = $dirtargetPath.$new_name;  
				if(move_uploaded_file($sourcePath, $targetPath))  
				{  
				     $output = \App\Config::SITE_PATH.'/user/'.md5($this->auth->isLoggedIn()).'/'.$new_name; 
				     echo json_encode(array('media' => $output, 'code' => $rand_file));
				     exit;
				}                 
			
			} else {
				     echo json_encode(array('error' => 'File Extension not allowed'));
				     exit;
			}

		 }  

	}
	
	public function loadaccountAction() {
		
		$load_account = $this->account->getAccountById($_POST['accid']);
		
		View::renderTemplate('Forms/'.$this->route_params['token'].'form.php', [
			'account'	=>	$load_account,
			'accid' => $_POST['accid']
		]);	
		
	}
	
	public function loadpostAction() {
		
		$url = $_POST['post_url'];
		$accid = $_POST['accid'];
		
		$account = $this->account->getAccountById($accid);
		$cookie_file = "user/".md5(trim($account['account_username']).trim($account['account_password'])).".txt";
		
		$content = $this->silent_visit($url, $cookie_file, $account['account_proxy']);

		$parse_content = str_get_html($content);
		
		foreach($parse_content->find('meta') as $meta) {
			$m_s[$meta->property] = $meta->content;
		}
		
		if(isset($m_s['og:description'])) {
			preg_match('/([0-9]+)\sLikes,\s([0-9]+)\sComments/', $m_s['og:description'], $i_stats);
		} else {
			echo json_encode(array('error' => 'true', 'message' => 'We couldn\'t resolve this url'));
			exit;
		}
		
		if(isset($m_s['al:ios:url'])) {
			preg_match('/[0-9]+/', $m_s['al:ios:url'], $i_mediaid);
		} else {
			echo json_encode(array('error' => 'true', 'message' => 'We couldn\'t resolve this url'));
			exit;
		}
		
		echo json_encode(array(
			'p_img' => isset($m_s['og:image']) ? $m_s['og:image'] : '',	
			'p_title' => isset($m_s['og:title']) ? $m_s['og:title'] : '',	
			'p_likes' => isset($i_stats[1]) ? $i_stats[1] : '',	
			'p_comments' => isset($i_stats[2]) ? $i_stats[2] : '',	
			'p_id' => isset($i_mediaid[0]) ? $i_mediaid[0] : ''
		));

		
	}

	public function checkAction() {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$category = $_POST['category'];
		$proxy = $_POST['proxy'];

		if($this->account->usernameExist($username)) {
		  
			echo json_encode(array('error' => 'Account already exists'));
		  
		} else {
			
			if($proxy != '') {
				$proxy_parse = parse_url($proxy);

				if(!$this->check_proxy($proxy_parse['host'].':'.$proxy_parse['port'])) {
					
					echo json_encode(array('error' => 'Proxy is Invalid!'));
					exit;
				}
				
			}
			
			$accid = $this->account->manuallyAddAccount($username, $password, $category, $proxy, $this->auth->isLoggedIn());
		  
	    	try {
	    		
	    		$ig = new \InstagramAPI\Instagram();
	    		if($proxy != '') {
	    			$ig->setProxy($proxy);
	    		}
	    		$login = $ig->login($username, $password);

	        	$response = $ig->people->getInfoById($login->getLoggedInUser()->getPk());
	        	$this->getProfileData($accid, $response);
	        	echo json_encode(array('success' => '1'));
	    		
	    	} catch(Exception $e) {
	    		
	    		$err = $e->getMessage();
	    		
	    	} catch (\InstagramAPI\Exception\IncorrectPasswordException $e) {
	    		
	    		$this->account->deleteAccount($accid);
	    		echo json_encode(array('error' =>  'Incorrect Username/Password !'));
	    	
	    	} catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
	                
				echo json_encode(array('challenge' => true, 'accid' => $accid));

	    	}
		  
		}

	}
	
	public function verifyAction() {
		
		$account = $this->account->getAccountById($_POST['account']);
		$choice = $_POST['choice'];
		
		try {
		
		$ig = new \InstagramAPI\Instagram();
		if($account['account_proxy'] != '') {
			$ig->setProxy($account['account_proxy']);
	    }
		$ig->login($account['account_username'], $account['account_password']);
		$this->insta_login = clone $ig;

		} catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
	    		
		    $iresp = $e->getResponse();

            $parts = explode("/", trim(json_decode($iresp, true)['challenge']['api_path'], "/"));

            $instaID = $parts[1];
            $challenge = $parts[2];
            
	        try {
	            $resp = $this->_sendVerificationCode($ig, $challenge, $instaID, $choice, false);
	        } catch (Exception $e) {
				echo $e->getMessage();
	            return false;
	        }
	        
	        echo json_encode(array('accid' => $account['id']));

	    }

	}
	
	public function activateAction() {
		
		$account = $this->account->getAccountById($_POST['account']);
		$captcha = $_POST['captcha'];
		
		try {
		
		$ig = new \InstagramAPI\Instagram();
		if($account['account_proxy'] != '') {
			$ig->setProxy($account['account_proxy']);
	    }
		$ig->login($account['account_username'], $account['account_password']);

		} catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
	    		
		    $iresp = $e->getResponse();

            $parts = explode("/", trim(json_decode($iresp, true)['challenge']['api_path'], "/"));

            $instaID = $parts[1];
            $challenge = $parts[2];
            
	        try {
	            $resp = $ig->approveChallengeVerificationCode(
	                $instaID,
	                $challenge,
	                $captcha);
	                
		        try {
		        	
		        	$nIig = new \InstagramAPI\Instagram();
		        	$nIig->login($account['account_username'], $account['account_password']);	
		        	$response = $nIig->people->getInfoById($instaID);
		        	
		        	$this->getProfileData($account['id'], $response);
		        	echo 'success';
		        	
		        } catch(Exception $e) {
		        	
		        	echo $e->getMessage();
		        	
		        }
		        
	        } catch (\Exception $e) {
	            echo $e->getMessage();
	        }
            
		}

	}
	
	public function getbytagsAction() {
		
		$account = $this->account->getAccountById('37');
		$cookie_file = "user/".md5(trim($account['account_username']).trim($account['account_password'])).".txt";
		
		$query = 'https://www.instagram.com/graphql/query/?query_hash='.$this->query_hash.'&variables='.urlencode('{"tag_name":"liverpool","first":50,"after":"'.$this->token.'"}');
		
		$content = $this->silent_visit($query, $cookie_file, $account['account_proxy']);
		
		foreach(json_decode($content, true)['data']['hashtag']['edge_hashtag_to_media']['edges'] as $edge) {
			$collected_ids[] = $edge['node']['owner']['id'];
		}

		$query = 'https://www.instagram.com/graphql/query/?query_hash='.$this->query_hash.'&variables='.urlencode('{"tag_name":"liverpool","first":50,"after":"'.json_decode($content, true)['data']['hashtag']['edge_hashtag_to_media']['page_info']['end_cursor'].'"}');
		
		$n_content = $this->silent_visit($query, $cookie_file, $account['account_proxy']);

		foreach(json_decode($n_content, true)['data']['hashtag']['edge_hashtag_to_media']['edges'] as $edge) {
			$collected_ids_bis[] = $edge['node']['owner']['id'];
		}	
		
		echo '<h1>First attempt</h1>';
		print_r($collected_ids);

		echo '<br><h1>Sec attempt</h1>';
		print_r($collected_ids_bis);	
		
	}
	
	public function preLogin($username, $password, $proxy) {
	
		$cookie_file = "user/".md5(trim($username).trim($password)).".txt";

		if(file_exists($cookie_file)) {
			unlink($cookie_file);
		}
		
		$fp = fopen($cookie_file,"wb");
		fwrite($fp,"");
		
		$this->visit($cookie_file, $proxy);
		preg_match('/csrftoken\s([0-9a-zA-Z]+)/', file_get_contents($cookie_file), $o);
		preg_match('/mid\s(.+)/', file_get_contents($cookie_file), $p);

		$request_headers[] = 'accept:'. '*/*';
		$request_headers[] = 'accept-encoding:'. 'gzip, deflate, br';
		$request_headers[] = 'accept-language:'. 'en-US,en;q=0.9,en-US;q=0.8,en;q=0.7';
		$request_headers[] = 'content-type:'. 'application/x-www-form-urlencoded';
		$request_headers[] = 'referer:'. 'https://www.instagram.com/accounts/login/';
		$request_headers[] = 'user-agent:'. 'Mozilla/5.0 (Windows NT x.y; Win64; x64; rv:10.0) Gecko/20100101 Firefox/10.0';
		$request_headers[] = 'x-csrftoken:'. $o[1];
		$request_headers[] = 'x-instagram-ajax:'. '1';
		$request_headers[] = 'x-requested-with:'. 'XMLHttpRequest';

		$login_content = $this->post_insta('https://www.instagram.com/accounts/login/ajax/', array('username' => $username, 'password' => $password, 'queryParams' => '{}'), $cookie_file, $proxy, $request_headers);
		
		//$login_content = $this->post_insta('https://www.instagram.com/accounts/login/ajax/', array('username' => $username, 'password' => $password, 'queryParams' => '{}'), $cookie_file, '', $request_headers);
		
		fclose($fp);

		return json_decode($login_content['body'], true);
		
	}
	
	public function getProfileData($accid, $data) {

		$account = $this->account->getAccountById($accid);

		$this->account->update_account_data($data->getUser()->getPk(), $data->getUser()->getFullName(), $data->getUser()->getHdProfilePicUrlInfo()->getUrl(), $data->getUser()->getFollowerCount(), $data->getUser()->getMediaCount(), $this->get_account_level($data->getUser()->getFollowerCount()), $accid);
		
	}
	
	private function get_account_level($followers) {
		
		if($followers < 7500 && $followers >= 100) {
			
			return 1;
			
		} else if($followers < 15000 && $followers >= 7501 ) {
			
			return 2;
			
		} else if($followers < 30000 && $followers >= 15001) {
			
			return 3;
			
		} else if($followers < 60000 && $followers >= 30001) {
			
			return 4;
			
		} else if($followers < 125000 && $followers >= 60001) {
			
			return 5;
			
		} else if($followers < 250000 && $followers >= 125001) {
			
			return 6;
			
		} else if($followers < 500000 && $followers >= 250001) {
			
			return 7;
			
		} else if($followers < 1000000 && $followers >= 500001) {
			
			return 8;
			
		} else if($followers < 2000000 && $followers >= 1000001) {
			
			return 9;
			
		}
	}
	
    private function _sendVerificationCode($Instagram, $Challenge, $instaID, $choice = 1, $replay = false) {
        try {
            $resp = $Instagram->sendChallengeVerificationCode(
                $instaID,
                $Challenge,
                $choice,
                $replay);
        } catch (\InstagramAPI\Exception\BadRequestException $e) {
            if (stripos($e->getMessage(), "Select a valid choice. 0 is not one of the available choices.") !== false && $choice != 1) {
                try {
                    $resp = $this->_sendVerificationCode($Instagram, $Challenge, $instaID, 1, $replay);
                } catch (Exception $e) {
                    throw $e;
                }
            } else {
                throw $e;
            }
        } catch(Exception $e) {
        	throw $e;
        }

        return $resp;
    }
	
	protected function activateProxy($accid, $userid) {
			
			$proxy = new Proxies();
			$account = $this->account->getAccountById($accid);
			
			if($this->user_details['user_proxy'] == '') {
				
				$proxies = $proxy->getWorkingProxies();
				$s_proxy = $proxies[0];
				
				if($this->user->setProxy($this->auth->isLoggedIn(), $s_proxy['proxy'])) {
					
					$proxy->setAssigned($s_proxy['id'], $userid);
					if($this->account->setAccountProxy($accid, $s_proxy['proxy'])) {
						
						return $s_proxy['proxy'];
						
					}
					
				}
				
			} else {
				
				if($account['account_proxy'] != $this->user_details['user_proxy']) {
					
					if($this->account->setAccountProxy($accid,  $this->user_details['user_proxy'])) {
						
						return $this->user_details['user_proxy'];
						
					}
					
				}
				
			}
			
		}
	
	protected function before() {

			
		if(!$this->auth->isLoggedIn()) {
      
    		 $this->redirect('/growth/login');
    		 
		} else {
			
			$this->user_details = $this->user->get_user_details($this->auth->isLoggedIn());

		}
		
	    
	}

}
?>
