<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Tasks;
use \App\Models\User;

class Task extends \Core\Controller
{

	public function addtaskAction() {
        
		$tasks = new Tasks($_POST);
		$action = $_POST['action'];
		$accid = $_POST['accid'];
		$done = 0;
		
		$account_details = $this->account->getAccountById($accid);
		
		if($action == 'addpost' && !isset($_POST['schedule'])) {
			
			$file_path = $this->getFilePath($account_details['account_userid'], $_POST['lists'][0]);
			$this->postphoto($file_path , $_POST['lists'][0], $_POST['message'], $account_details);
			$done = 1;

			
		} else if($action == 'addstory' && !isset($_POST['schedule'])) {

			$file_path = $this->getFilePath($account_details['account_userid'], $_POST['lists'][0]);
			$this->poststory($file_path , $_POST['lists'][0], $_POST['message'], $account_details);
			$done = 1;

			
		} else if($action == 'addalbum' && !isset($_POST['schedule'])) {
			
			foreach($_POST['lists'] as $p_l) {
				$file_path[] = $this->getFilePath($account_details['account_userid'], $p_l);
			}
			$this->postalbum($file_path , $_POST['lists'], $_POST['message'], $account_details);
			$done = 1;

		}
		
		if($tasks->addTasks($action, $this->auth->isLoggedIn(), $account_details['id'], $done)) {
			echo 'success';
		}
		
    }
    
    public function listAction() {
        
		$n_accounts = $this->account->getAll($this->auth->isLoggedIn());

		View::renderTemplate('Task/list.php', [
			'user'	=>	$this->user->get_user_details($this->auth->isLoggedIn()),
			'accounts'	=>	$n_accounts
		]);	
    }
    
    public function loadtasksAction() {
    	
        $task = new Tasks();
    	$account_details = $this->account->getAccountById($_POST['accid']);
    	
    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($account_details['account_username'], $account_details['account_password']);

    	} catch(Exception $e) {
    		
    		$err = $e->getMessage();
    		echo $err;
    		
		}        
		
        $t_types = $task->getAllTaskTypes();
		
		if(isset($this->route_params['token'])) {
			
			$tasks = $task->getAllTasksByAction($_POST['accid'], $this->route_params['token']);
			$type = $this->route_params['token'];
			
		} else {
			
			$tasks = $task->getAllTasks($_POST['accid']);
			$type = 'all';
			
		}
		
		foreach($tasks as $t) {
			
			if(!empty(json_decode($t['task_fuids_done'], true))) {
				foreach(json_decode($t['task_fuids_done'], true) as $index => $tfuid) {
					if($task->getTaskTypeId($t['task_typeid']) == 'automessage' || $task->getTaskTypeId($t['task_typeid']) == 'autofollowtags' || $task->getTaskTypeId($t['task_typeid']) == 'autofollowlocations' || $task->getTaskTypeId($t['task_typeid']) == 'autofollowusername' || $task->getTaskTypeId($t['task_typeid']) == 'autounfollows') {
						
						$record = $task->getRrecordById($tfuid);
						
						if($record === false) {
							
							$response = $ig->people->getInfoById($tfuid);
							$final_array[$t['id']][$index]['id'] = $tfuid;
							$final_array[$t['id']][$index]['username'] = $response->getUser()->getUsername();
							
							$task->addRecord($tfuid, $final_array[$t['id']][$index]['username']);
							
						} else {
							
							$final_array[$t['id']][$index]['id'] = $record['record_id'];
							$final_array[$t['id']][$index]['username'] = $record['record_value'];
							
						}
						
					}
					
					if($task->getTaskTypeId($t['task_typeid']) == 'getlikes' || $task->getTaskTypeId($t['task_typeid']) == 'getcomments') {
						
						$u_record = $task->getRrecordById($tfuid);
						$m_record = $task->getRrecordById(json_decode($t['task_scrap_elements'], true)[0]);
						
						if($u_record === false) {
							
							$response = $ig->people->getInfoById($tfuid);
							$final_array[$t['id']][$index]['id'] = $tfuid;
							$final_array[$t['id']][$index]['username'] = $response->getUser()->getUsername();

							$task->addRecord($tfuid, $final_array[$t['id']][$index]['username']);
						
						} else {

							$final_array[$t['id']][$index]['id'] = $u_record['record_id'];
							$final_array[$t['id']][$index]['username'] = $u_record['record_value'];							
							
						}
						
						if($m_record === false) {
						
							$media_response = $ig->media->getInfo(json_decode($t['task_scrap_elements'], true)[0]);
							$final_array[$t['id']][$index]['mediacode'] = $media_response->getItems()[0]->getCode();
							
							$task->addRecord(json_decode($t['task_scrap_elements'], true)[0], $final_array[$t['id']][$index]['mediacode']);
						
						} else {
							
							$final_array[$t['id']][$index]['mediacode'] = $m_record['record_value'];
							
						}
						
					}
					
					if($task->getTaskTypeId($t['task_typeid']) == 'autolikelocations' || $task->getTaskTypeId($t['task_typeid']) == 'autoliketags' || $task->getTaskTypeId($t['task_typeid']) == 'autolikeusername') {
						
						$record = $task->getRrecordById($tfuid);
						
						if($record === false) {
							
							$media_response = $ig->media->getInfo($tfuid);
							$final_array[$t['id']][$index]['mediacode'] = $media_response->getItems()[0]->getCode();

							$task->addRecord($tfuid, $final_array[$t['id']][$index]['mediacode']);
							
						} else {
							
							$final_array[$t['id']][$index]['mediacode'] = $record['record_value'];
							
						}
						
					}
					
					if($task->getTaskTypeId($t['task_typeid']) == 'addpost' || $task->getTaskTypeId($t['task_typeid']) == 'addstory' || $task->getTaskTypeId($t['task_typeid']) == 'addalbum') {

						$final_array[$t['id']][$index]['mediacode'] = $tfuid;
						$final_array[$t['id']][$index]['message'] = $t['task_message'];
						
					}
				}
			} else {
				$final_array[$t['id']] = [];
			}
			
			$tsks[$t['id']] = array(
				'name'	=>	$t['task_name'],
				'delay'	=>	$t['task_delay'],
				'threads'	=>	$t['task_threads'],
				'max_day'	=>	$t['task_max_day'],
				'type'	=>	$task->getTaskTypeId($t['task_typeid']),
				'is_done'	=>	$t['task_done'],
				'is_stopped'	=>	$t['task_stop'],
				'results'	=>	$final_array[$t['id']],
				'max'	=>	$t['task_max_total']
			);
			
		}

		View::renderTemplate('Forms/tasks.php', [
		    'tasks' => (!empty($tsks) ? $tsks : array()),
		    'type' => $type,
		    'tasks_types' => $t_types,
		    'user_folder' => "user/".md5($this->auth->isLoggedIn()),
			'accid' => $_POST['accid']
		]);
		

    }
    
    public function edittaskAction() {
    	$task = new Tasks($_POST);
    	
    	if(isset($this->route_params['token'])) {
    		
    		if($task->editTaskStatus($this->route_params['token'])) {
    			echo 'true';
    		}
    	}
    }
    
    public function processfunction() {
    	
	    $task = new Tasks();
	    $user = new User();

	    $open_tasks = $task->getTasks();

	    if(count($open_tasks) > 0) {
	    	
		    $o_task = $open_tasks[0];
		    
			$task->update_processing_task('1', $o_task['id']);
			
	    	$tasks_done = ($o_task['task_fuids_done_today'] != '' ? json_decode($o_task['task_fuids_done_today'], true) : array());
	    	$tasks_done_today = ($o_task['task_fuids_done'] != '' ? json_decode($o_task['task_fuids_done'], true) : array());
	    	
			$account = $this->account->getAccountById($o_task['task_accid']);
			
			$user = $this->user->get_user_details($o_task['task_userid']);
			
			if($o_task['task_action'] == 'getlikes') {
				
				$pre_acting_accounts = $this->account->getAccountByCategory($o_task['task_category'], $o_task['task_accid']);
				
				foreach($pre_acting_accounts as $temp_acting_account) {
					
					$acting_accounts[$temp_acting_account['account_level']][] = $temp_acting_account;
				}
				
				if(($account['system_likes'] == 0 || $account['system_likes'] > 1) && $account['system_likes'] < 500) {
					
					if($account['account_level'] >= 3) {
				
						$index_one = $account['account_level'];
						$index_two = $account['account_level'] - 1;
						$index_three = $account['account_level'] - 2;
						$index_four = $account['account_level'] + 1;
						
						foreach($acting_accounts as $index => $arr_acc) {

							if($index == $index_one) {
								
								$limit = $account['system_index1'];
								foreach($arr_acc as $a_acc) {
							
									if($limit >= 0 && $limit < 7) {
										
										$this->initiate_like($task, $account, $a_acc, $o_task);
										$this->account->update_target_account_likes($a_acc['id']);
										$limit++;
										
									} else {
										
										continue 2;
										
									}
									
								}
								
								$this->account->update_account_index('1', $limit, $account['id']);
								
							} else if($index == $index_two || $index == $index_three || $index == $index_four) {
								
								if($account['system_index2'] == 0) {
										
										$this->initiate_like($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_index('2', '1', $account['id']);
										$this->account->update_target_account_likes($arr_acc[0]['id']);
										continue;
										
								}
									
								if($account['system_index3'] == 0) {
										
										$this->initiate_like($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_index('3', '1', $account['id']);
										$this->account->update_target_account_likes($arr_acc[0]['id']);
										continue;
										
								}
									
								if($account['system_index4'] == 0) {
										
										$this->initiate_like($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_index('4', '1', $account['id']);
										$this->account->update_target_account_likes($arr_acc[0]['id']);
										continue;
										
								}
								
								$this-> account->initiate_account_index($account['id']);
								
							}
							
						}
						
					}
				
				}
			
			} else if($o_task['task_action'] == 'getcomments') {
	
				$pre_acting_accounts = $this->account->getAccountByCategory($o_task['task_category'], $o_task['task_accid']);
				
				foreach($pre_acting_accounts as $temp_acting_account) {
					
					$acting_accounts[$temp_acting_account['account_level']][] = $temp_acting_account;
				}
				
				if(($account['system_comments'] == 0 || $account['system_comments'] > 1) && $account['system_comments'] < 200) {
					
					if($account['account_level'] >= 3) {
				
						$index_one = $account['account_level'];
						$index_two = $account['account_level'] - 1;
						$index_three = $account['account_level'] - 2;
						$index_four = $account['account_level'] + 1;
						
						foreach($acting_accounts as $index => $arr_acc) {

							if($index == $index_one) {
								
								$limit = $account['system_comment_index1'];
								foreach($arr_acc as $a_acc) {
							
									if($limit >= 0 && $limit < 7) {
										
										$this->initiate_comment($task, $account, $a_acc, $o_task);
										$this->account->update_target_account_comments($a_acc['id']);
										$limit++;
										
									} else {
										
										continue 2;
										
									}
									
								}
								
								$this->account->update_account_comment_index('1', $limit, $account['id']);
								
							} else if($index == $index_two || $index == $index_three || $index == $index_four) {
								
								if($account['system_comment_index2'] == 0) {
										
										$this->initiate_comment($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_comment_index('2', '1', $account['id']);
										$this->account->update_target_account_comments($arr_acc[0]['id']);
										continue;
										
								}
									
								if($account['system_comment_index3'] == 0) {
										
										$this->initiate_comment($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_comment_index('3', '1', $account['id']);
										$this->account->update_target_account_comments($arr_acc[0]['id']);
										continue;
										
								}
									
								if($account['system_comment_index4'] == 0) {
										
										$this->initiate_comment($task, $account, $arr_acc[0], $o_task);
										$this->account->update_account_comment_index('4', '1', $account['id']);
										$this->account->update_target_account_comments($arr_acc[0]['id'], '1');
										continue;
										
								}
								
								$this-> account->initiate_comment_account_index($account['id']);
								
							}
							
						}
						
					}
				
				}
				
			} else if($o_task['task_action'] == 'automessage') {
						
				if(empty($o_task['task_fuids_queue'])) {
					
			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
			    		
			    		$rankToken = \InstagramAPI\Signatures::generateUUID();
			    		
			    		$followers = array();
			    		$following = array();
			    		
					    $maxId = null;
					    $f_maxId = null;
					    
					    do {
					    	
					        $response = $ig->people->getFollowers($account['account_id'], $rankToken, $maxId);
					        $f_response = $ig->people->getFollowing($account['account_id'], $rankToken, $f_maxId);
					        
					        $followers = array_merge($followers, $response->getUsers());
					        $following = array_merge($following, $f_response->getUsers());
					        
					        $maxId = $response->getNextMaxId();
					        $f_maxId = $f_response->getNextMaxId();
					        
					    } while ($maxId !== null && $f_maxId !== null);	  
					    
				        foreach($followers as $follower_array) {
				        	$this->add_new_record($task, $follower_array->getPk(), $follower_array->getUsername());
				        	$followers_pks[] = $follower_array->getPk();
				        }
				        
				        foreach($following as $following_array) {
				        	$this->add_new_record($task, $following_array->getPk(), $following_array->getUsername());
				        	$following_pks[] = $following_array->getPk();
				        }
				        
				        $all_pks = json_encode(array_unique(array_merge($followers_pks, $following_pks)));
				        $task->update_task_fuids($all_pks, $o_task['id']);
			    		
			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
			    	}			
					
				
				} else {
					$fuids = json_decode($o_task['task_fuids_queue'], true);
					if(count($fuids) > 0) {
						
						$user_pk = $fuids[0];
						
						try {
							
				    		$ig = new \InstagramAPI\Instagram();
				    		$login = $ig->login($account['account_username'], $account['account_password']);

				    		$recipients = 
							[
								'users' => array($user_pk)
							];
				    		
				    		$response = $ig->direct->sendText($recipients, json_decode($o_task['task_scrap_elements'], true)[0]);
				    		
				    		if(json_decode($response, true)['status_code'] == '200') {
				    			
				    			unset($fuids[0]);
				    			foreach($fuids as $s_fuid) {
				    				$all_pks[] = $s_fuid;
				    			}
				    			
				    			$task->update_single_task_done($user_pk, $o_task['id']);
				    			$task->update_task_fuids(json_encode($all_pks), $o_task['id']);
				    			
				    		}
							
						} catch(Exception $e) {
							echo $e->getMessage();
						}
						
					} else {
						
						$task->validateTask($o_task['id']);
						
					}
					
				}
				
			} else if($o_task['task_action'] == 'autofollowtags') {
				
				if(empty($o_task['task_fuids_queue'])) {
					
					$hashtags = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($hashtags));
					$all_pks = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_pks = $this->loop_through_pks($ig, 'hashtags', $task, $o_task, $hashtags, $l_tag, $all_pks);
						
						do {
							
							$all_pks = $this->loop_through_pks($ig, 'hashtags', $task, $o_task, $hashtags, $l_tag, $all_pks);
							
						} while(count($all_pks) <= $o_task['task_max_day']);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_pks))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
    	
				
				} else {
					
					$target_pks = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$accid = $target_pks[$i];
						$this->followAccount($accid, $account);
						
		    			unset($target_pks[$i]);
		    			$task->update_single_task_done($accid, $o_task['id']);
		    			
					}

	    			foreach($target_pks as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);

				}
				
			} else if($o_task['task_action'] == 'autofollowlocations') {
				
				if(empty($o_task['task_fuids_queue'])) {
					
					$locations = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($locations));
					$all_pks = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_pks = $this->loop_through_pks($ig, 'locations', $task, $o_task, $locations, $l_tag, $all_pks);
						
						do {
							
							$all_pks = $this->loop_through_pks($ig, 'locations', $task, $o_task, $locations, $l_tag, $all_pks);
							
						} while(count($all_pks) <= $o_task['task_max_day']);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_pks))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
    	
				
				} else {
					
					$target_pks = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$accid = $target_pks[$i];
						$this->followAccount($accid, $account);
						
		    			unset($target_pks[$i]);
		    			$task->update_single_task_done($accid, $o_task['id']);
		    			
					}

	    			foreach($target_pks as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);

				}
				
			
			} else if($o_task['task_action'] == 'autofollowusername') {
				
				if(empty($o_task['task_fuids_queue'])) {
					
					$usernames = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($usernames));
					$all_pks = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_pks = $this->loop_through_pks($ig, 'usernames', $task, $o_task, $usernames, $l_tag, $all_pks);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_pks))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
    	
				
				} else {
					
					$target_pks = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$accid = $target_pks[$i];
						$this->followAccount($accid, $account);
						
		    			unset($target_pks[$i]);
		    			$task->update_single_task_done($accid, $o_task['id']);
		    			
					}

	    			foreach($target_pks as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);

				}
			
			} else if($o_task['task_action'] == 'autounfollows') {
				
				if(empty($o_task['task_fuids_queue'])) {
					
			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
			    		
			    		$rankToken = \InstagramAPI\Signatures::generateUUID();
			    		
			    		$following = array();
			    		
					    $f_maxId = null;
					    
					    do {
					    	
					        $f_response = $ig->people->getFollowing($account['account_id'], $rankToken, $f_maxId);
					        
					        $following = array_merge($following, $f_response->getUsers());
					        
					        $f_maxId = $f_response->getNextMaxId();
					        
					    } while ($f_maxId !== null);	  
				        
				        foreach($following as $following_array) {
				        	$this->add_new_record($task, $following_array->getPk(), $following_array->getUsername());
				        	$following_pks[] = $following_array->getPk();
				        }
				        
				        $all_pks = json_encode(array_unique($following_pks));
				        $task->update_task_fuids($all_pks, $o_task['id']);
			    		
			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
			    	}			
				
				} else {

					$target_pks = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$accid = $target_pks[$i];
						$this->unFollowAccount($accid, $account);
						
		    			unset($target_pks[$i]);
		    			$task->update_single_task_done($accid, $o_task['id']);
		    			
					}

	    			foreach($target_pks as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);
					
				}
				
			
			} else if($o_task['task_action'] == 'autoliketags') {

				if(empty($o_task['task_fuids_queue'])) {
					
					$hashtags = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($hashtags));
					$all_medias = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_medias = $this->loop_through_medias($ig, 'hashtags', $task, $o_task, $hashtags, $l_tag, $all_medias);
						
						do {
							
							$all_medias = $this->loop_through_medias($ig, 'hashtags', $task, $o_task, $hashtags, $l_tag, $all_medias);
							
						} while(count($all_medias) <= $o_task['task_max_day']);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_medias))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
				
				} else {
					
					$target_medias = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$mediaid = $target_medias[$i];
						$this->likeMedia($task, $mediaid, $account);
						
		    			unset($target_medias[$i]);
		    			$task->update_single_task_done($mediaid, $o_task['id']);
		    			
					}

	    			foreach($target_medias as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);
					
				}
				
			} else if($o_task['task_action'] == 'autolikelocations') {

				if(empty($o_task['task_fuids_queue'])) {
					
					$locations = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($locations));
					$all_medias = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_medias = $this->loop_through_medias($ig, 'locations', $task, $o_task, $locations, $l_tag, $all_medias);
						
						do {
							
							$all_medias = $this->loop_through_medias($ig, 'locations', $task, $o_task, $locations, $l_tag, $all_medias);
							
						} while(count($all_medias) <= $o_task['task_max_day']);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_medias))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
    	
				
				
				} else {
					
					$target_medias = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$mediaid = $target_medias[$i];
						$this->likeMedia($task, $mediaid, $account);
						
		    			unset($target_medias[$i]);
		    			$task->update_single_task_done($mediaid, $o_task['id']);
		    			
					}

	    			foreach($target_medias as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);
					
				}
				
			
			} else if($o_task['task_action'] == 'autolikeusername') {
				
				if(empty($o_task['task_fuids_queue'])) {
					
					$usernames = json_decode($o_task['task_scrap_elements'], true);
					$l_tag = ceil($o_task['task_max_day']/count($usernames));
					$all_medias = ((!empty(json_decode($o_task['task_fuids_done'], true))) ? json_decode($o_task['task_fuids_done'], true) : array());

			    	try {
			    		
			    		$ig = new \InstagramAPI\Instagram();
			    		$login = $ig->login($account['account_username'], $account['account_password']);
						
						$all_medias = $this->loop_through_medias($ig, 'usernames', $task, $o_task, $usernames, $l_tag, $all_medias);
						
						$task->update_task_fuids(json_encode($this->format_array(array_unique($all_medias))), $o_task['id']);

			    	} catch(Exception $e) {
			    		
			    		$err = $e->getMessage();
			    		echo $err;
			    		
					}
    	
				
				} else {
					
					$target_medias = json_decode($o_task['task_fuids_queue']);
					$thread = (($o_task['task_threads'] < 60) ? '1' : ceil($o_task['task_threads']/60.0));
					for($i=0; $i<$thread; $i++) {
						
						$mediaid = $target_medias[$i];

		    			if($this->likeMedia($task, $mediaid, $account)) {
			    			$task->update_single_task_done($mediaid, $o_task['id']);
		    			}
		    			
		    			unset($target_medias[$i]);
		    			
					}

	    			foreach($target_medias as $s_fuid) {
	    				$all_pks[] = $s_fuid;
	    			}					
					$task->update_task_fuids(json_encode($all_pks), $o_task['id']);
					
				}
				
			}
			
			$task->update_processing_task('0', $o_task['id']);
			
	    }

    }
    
    public function scheduleAction() {

	    $task = new Tasks();
	    $user = new User();

	    $open_tasks = $task->getSchedules();

	    if(count($open_tasks) > 0) {
	    	
		    $o_task = $open_tasks[0];
		    
			$task->update_processing_task('1', $o_task['id']);

			$account = $this->account->getAccountById($o_task['task_accid']);
			
			$user = $this->user->get_user_details($o_task['task_userid']);
			
			if($o_task['task_action'] == 'addpost') {
				
				$t_offset = floatval($user['user_timezone']);
				$ammount = 11 + $t_offset;
				
				if(strtotime(date("Y-m-d H:i:s", strtotime($ammount." hours"))) > $o_task['task_schedule']) {
					
					$file_path = $this->getFilePath($account['account_userid'], json_decode($o_task['task_scrap_elements'], true)[0]);
					$this->postphoto($file_path , json_decode($o_task['task_scrap_elements'], true)[0], $o_task['message'], $account);
				
				}
				
			} else if($o_task['task_action'] == 'addstory') {
				
				$t_offset = floatval($user['user_timezone']);
				$ammount = 11 + $t_offset;
				
				if(strtotime(date("Y-m-d H:i:s", strtotime($ammount." hours"))) > $o_task['task_schedule']) {
					
					$file_path = $this->getFilePath($account['account_userid'], json_decode($o_task['task_scrap_elements'], true)[0]);
					$this->poststory($file_path , json_decode($o_task['task_scrap_elements'], true)[0], $o_task['message'], $account);
				
				}
				
			} else if($o_task['task_action'] == 'addalbum') {
				
				$t_offset = floatval($user['user_timezone']);
				$ammount = 11 + $t_offset;
				
				if(strtotime(date("Y-m-d H:i:s", strtotime($ammount." hours"))) > $o_task['task_schedule']) {

					foreach(json_decode($o_task['task_scrap_elements'], true) as $p_l) {
						$file_path[] = $this->getFilePath($account['account_userid'], $p_l);
					}
					
					$this->postalbum($file_path , json_decode($o_task['task_scrap_elements'], true), $o_task['message'], $account);

				
				}
				
			}
			
			$task->update_task_fuids($o_task['task_scrap_elements'], $o_task['id']);
			
			$task->update_processing_task('0', $o_task['id']);
			
	    }
    }
    
	public function processaAction() {

			
			$this->processfunction();

	}
	public function processbAction() {
			
			sleep(3);
			$this->processfunction();

	}
	public function processcAction() {

			sleep(6);
			$this->processfunction();

	}
	public function processdAction() {
		
			sleep(9);
			$this->processfunction();
	
	}
	public function processeAction() {
			sleep(12);
			$this->processfunction();
	}
	public function processfAction() {
		
			sleep(15);
			$this->processfunction();
	
	}
	public function processgAction() {
		
			sleep(18);
			$this->processfunction();
				
	}
	
	public function add_new_record($task, $tfuid, $value) {

		$record = $task->getRrecordById($tfuid);
		
		if($record === false) {

			$task->addRecord($tfuid, $value);
			
		}
						
	}
	
    public function loadplacesAction() {

	    $account = $this->account->getAccountById($_POST['accid']);
	    $keyword = $_POST['keyword'];
	    $final_places = [];
	    
	    	try {
	    		
	    		$ig = new \InstagramAPI\Instagram();
	    		$login = $ig->login($account['account_username'], $account['account_password']);

	    		$resp = $ig->location->findPlaces($keyword);
				
				foreach($resp->getItems() as $item) {
					$final_places[$item->getLocation()->getPk()] = $item->getLocation()->getName();
				}
				
				echo json_encode(array('stat' => ((!empty($final_places)) ? 'success' : 'fail'), 'elements' => $final_places));
	    		
	    	} catch(Exception $e) {
	    		
	    		$err = $e->getMessage();
	    		echo $err;
	    		
			}
	    
    }
    
    public function initiate_like($task, $account, $a_acc, $o_task) {

		// Make account following
		$this->prepareInstaAction($account['system_followers'], $account['account_id'], $a_acc, $o_task['task_accid']);

		$targetedMedias = json_decode($o_task['task_scrap_elements'], true)[0];

		if($targetedMedias != '') {
			
				if($this->hasNotMedia($o_task['task_fuids_done'], $a_acc['account_id']) == false) {

					$this->likeMedia($task, $targetedMedias, $a_acc);
					$task->update_task_done($targetedMedias, $a_acc['account_id'], $o_task['id']);
					
				}
			
		} else {

			$this->likeMedia($task, $targetedMedias, $a_acc);
			$task->update_task_done($targetedMedias, $a_acc['account_id'], $o_task['id']);
			
		}
		
    }
    
    public function initiate_comment($task, $account, $a_acc, $o_task) {

		// Make account following
		$this->prepareInstaAction($account['system_followers'], $account['account_id'], $a_acc, $o_task['task_accid']);

		$targetedMedias = json_decode($o_task['task_scrap_elements'], true)[0];
		if($targetedMedias != '') {
			
			if($this->hasNotMedia($o_task['task_fuids_done'], $a_acc['account_id']) == false) {
				
				$this->commentMedia($task, $targetedMedias, json_decode($o_task['task_message'], true)[0], $a_acc);
				$task->update_task_done($targetedMedias, $a_acc['account_id'], $o_task['id']);
				
			}								
			
		} else {
			
			$this->commentMedia($task, $targetedMedias, json_decode($o_task['task_message'], true)[0], $a_acc);
			$task->update_task_done($targetedMedias, $a_acc['account_id'], $o_task['id']);
			
		}
		
    }
    
    public function prepareInstaAction($s_followers, $accid, $actingAcc, $taskId) {
    	
		if(!empty(json_decode($s_followers, true))) {

			if($this->recursive_array_search($actingAcc['account_id'], json_decode($s_followers, true)) === false) {
				
				$this->followAccount($accid, $actingAcc);
				$this->account->update_account_followers($actingAcc['account_id'], $taskId);
			
			}
			
		} else {
			
			$this->followAccount($accid, $actingAcc);
			$this->account->update_account_followers($actingAcc['account_id'], $taskId);
			
		}
		
    }
    
    public function hasNotMedia($mediaDone, $accingId) {

    	if(empty(json_decode($mediaDone, true))) {

    		return false;
    		
    	} else {

    		if($this->recursive_array_search($accingId, json_decode($mediaDone, true)) === false) {
    			
    			return false;
    			
    		}
    		
    	}
    	
    	return true;
    }
    
    public function followAccount($targetId, $actingAccount) {
   
    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);

			$ig->people->follow($targetId);
    		
    	} catch(Exception $e) {
    		
    		$err = $e->getMessage();
    		echo $err;
    		
    	}

    }
    
	public function unFollowAccount($targetId, $actingAccount) {
   
    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);

			$ig->people->unfollow($targetId);
    		
    	} catch(Exception $e) {
    		
    		$err = $e->getMessage();
    		echo $err;
    		
    	}

    }
    
    public function likeMedia($task, $mediaId, $actingAccount) {

    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);
			
			$ig->media->like($mediaId);
			
			$media_response = $ig->media->getInfo($mediaId);
			$mediaCode = $media_response->getItems()[0]->getCode();
			$this->add_new_record($task, $mediaId, $mediaCode);
			
			return true;
			
    	} catch(\InstagramAPI\Exception\BadRequestException $e) {
    		
    		return false;
    		
    	}
		
    }
    
    public function commentMedia($task, $mediaId, $comment, $actingAccount) {

    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);

			$ig->media->comment($mediaId,$comment);
			
			$media_response = $ig->media->getInfo($mediaId);
			$mediaCode = $media_response->getItems()[0]->getCode();
			$this->add_new_record($task, $mediaId, $mediaCode);
    		
    	} catch(Exception $e) {
    		
    		$err = $e->getMessage();
    		echo $err;
    		
    	}
		
    }
    
    public function loop_through_pks($ig, $type, $task, $o_task, $elements, $l_tag, $all_pks = []) {

		foreach($elements as $elet) {
						
			$rankToken = \InstagramAPI\Signatures::generateUUID();
		    $maxId = null;
			$count_items = 0;
			
			$responsearray = array();
			if($type == 'usernames') {
				
			    $response = $ig->people->search($elet);
			    if($response->isUsers()) {
			    	foreach($response->getUsers() as $single_user) {

						if(!empty($all_pks)) {
							if($this->recursive_array_search($single_user->getPk(), $all_pks) !== false) {
								continue;
							}
						}
						
						if($single_user->getFriendshipStatus()->getFollowing() != '1') {
							$this->add_new_record($task, $single_user->getPk(), $single_user->getUsername());
							$all_pks[] = $single_user->getPk();
							$count_items++;
						}
						
						if($count_items > $l_tag) {
							continue 2;
						}
						if(count($all_pks) > $o_task['task_max_day']) {
							return $all_pks;
						}
						
			    	}
			    }
			    
			} else {
				
				do {
		    	
		    	if($type == 'locations') {
			        $response = $ig->location->getFeed($elet,$rankToken,$maxId);
		    	} elseif($type == 'hashtags') {
		    		$response = $ig->hashtag->getFeed(str_replace(' ', '', $elet),$rankToken,$maxId);
		    	
		    	}
				
				if($response->isItems()) {
					foreach($response->getItems() as $singler_array) {
						if(!empty($all_pks)) {
							if($this->recursive_array_search($singler_array->getUser()->getPk(), $all_pks) !== false) {
								continue;
							}
						}
						$this->add_new_record($task, $singler_array->getUser()->getPk(), $singler_array->getUser()->getUsername());
						$all_pks[] = $singler_array->getUser()->getPk();
						$count_items++;

						if($count_items > $l_tag) {
							continue 3;
						}
						if(count($all_pks) > $o_task['task_max_day']) {
							return $all_pks;
						}
						
						if($type == 'hashtags') {
							
							if($singler_array->isLikers()) {
								foreach($singler_array->getLikers() as $signle_array_liker) {
									if(!empty($all_pks)) {
										if($this->recursive_array_search($signle_array_liker->getPk(), $all_pks) !== false) {
											continue;
										}
									}
									
									$this->add_new_record($task, $signle_array_liker->getPk(), $signle_array_liker->getUsername());
									$all_pks[] = $signle_array_liker->getPk();
									$count_items++;
									
									if($count_items > $l_tag) {
										continue 4;
									}
									if(count($all_pks) > $o_task['task_max_day']) {
										return $all_pks;
									}
									
								}
							}
							
						}

					}
				}
		        $maxId = $response->getNextMaxId();
				
		    } while ($maxId !== null);
		    
			}
						    
		}
		
		return $all_pks;
    }
    
    public function loop_through_medias($ig, $type, $task, $o_task, $elements, $l_tag, $all_medias = []) {

		foreach($elements as $elet) {
						
			$rankToken = \InstagramAPI\Signatures::generateUUID();
		    $maxId = null;
			$count_items = 0;
			
			$responsearray = array();
			if($type == 'usernames') {
				
			    $response = $ig->people->search($elet);
			    
			    if($response->isUsers()) {
			    	foreach($response->getUsers() as $single_user) {
			    		
			    		try {
							$userfeed = $ig->timeline->getUserFeed($single_user->getPk());
							if($userfeed->isItems()) {
								foreach($userfeed->getItems() as $m_item) {
									
									if(!empty($all_medias)) {
										if($this->recursive_array_search($m_item->getPk(), $all_medias) !== false) {
											continue;
										}
									}
									
									$this->add_new_record($task, $single_user->getPk(), $single_user->getCode());
									$all_medias[] = $single_user->getPk();
									$count_items++;
									
									if($count_items > $l_tag) {
										continue 2;
									}
									if(count($all_medias) > $o_task['task_max_day']) {
										return $all_medias;
									}
									
								}
							} else {
								continue;
							}
			    		} catch(\InstagramAPI\Exception\BadRequestException $e) {
			    			continue;
			    		}
			    	}
			    }
			    
			} else {
				
				do {
		    	
		    	if($type == 'locations') {
			        $response = $ig->location->getFeed($elet,$rankToken,$maxId);
		    	} elseif($type == 'hashtags') {
		    		$response = $ig->hashtag->getFeed(str_replace(' ', '', $elet),$rankToken,$maxId);
		    	}
				
				if($response->isItems()) {
					foreach($response->getItems() as $singler_array) {
						if(!empty($all_medias)) {
							if($this->recursive_array_search($singler_array->getPk(), $all_medias) !== false) {
								continue;
							}
						}
						$this->add_new_record($task, $singler_array->getPk(), $singler_array->getCode());
						$all_medias[] = $singler_array->getPk();
						$count_items++;

						if($count_items > $l_tag) {
							continue 3;
						}
						if(count($all_medias) > $o_task['task_max_day']) {
							return $all_medias;
						}

					}
				}
		        $maxId = $response->getNextMaxId();
				
		    } while ($maxId !== null);
		    
			}
						    
		}
		
		return $all_medias;
    }
    
    protected function format_array($array) {
    	$return_array = array();
    	
    	foreach($array as $a) {
    		$return_array[] = $a;
    	}
    	
    	return $return_array;
    }
    
    public function msgAction() {
    	
    	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		//$login = $ig->login('charismaticlabs', 'Naren@123');
    		//$login = $ig->login('micheldunlap3500', 'n0th1ngh3r3@');
    		//$login = $ig->login('lovesharingeconomy.com@gmail.com', 'India@2018_Tony');
    		$login = $ig->login('elmehdielboukili', 'n0th1ngh3r3@');
    		
    		$rankToken = \InstagramAPI\Signatures::generateUUID();
    		$followers = array();
		    $maxId = null;
		    do {
		        $response = $ig->people->getFollowers('1837794196', $rankToken, $maxId);
		        $followers = array_merge($followers, $response->getUsers());
		        $maxId = $response->getNextMaxId();
		    } while ($maxId !== null);	  
		    
	        foreach($followers as $follower_array) {
	        	echo $follower_array->getUsername().'<br>';
	        }
    		/*$recipients = 
			[
				'users' => array('6092624329') // must be an [array] of valid UserPK IDs
			];
    		
    		echo $ig->direct->sendText($recipients, 'Test from server');*/
    		
    	} catch(Exception $e) {
    		
    		$err = $e->getMessage();
    		echo $err;
    		
    	} catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
    		

			    $iresp = $e->getResponse();
			    echo $iresp;
    		
    	}
    
    }
    
    public function postphoto($mediaFile, $imgCode, $caption, $actingAccount) {
    	
       	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);

			$data = getimagesize($mediaFile);
			$width = $data[0];
			$height = $data[1];

			if(floatval($width/$height) < 0.8) {
				
				$neWidth = 0.8*$height;
				
				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
					$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile, $height);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile);
			
			} else if(floatval($width/$height) > 1.910) {

				$neWidth = 1.910*$height;
				
				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
					$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile, $height);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile);
				
			} else {

				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
					$this->resize(1000, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile);

			}

			$metadata = ['caption' => $caption];
			$ig->timeline->uploadPhoto($new_file, $metadata);

			return true;
			
    	} catch(\InstagramAPI\Exception\BadRequestException $e) {
    		
    		return false;
    		
    	}
    	
    }
 
	public function poststory($mediaFile, $imgCode, $caption, $actingAccount) {
	    	
       	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);

			$data = getimagesize($mediaFile);
			$width = $data[0];
			$height = $data[1];

			if(floatval($width/$height) < 0.56) {
				
				$neWidth = 0.55*$height;
				
				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile))) {
					$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story', $mediaFile, $height);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile);
			
			} else if(floatval($width/$height) > 0.67) {

				$height = $width/0.66;
				$neWidth = $width;
				
				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile))) {
					$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story', $mediaFile, $height);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile);
				
			} else {

				if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile))) {
					$this->resize(1000, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story', $mediaFile);
				}
				
				$new_file = 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_story.'.$this->get_extension($mediaFile);

			}

			$metadata = ['caption' => $caption];
			$ig->story->uploadPhoto($new_file, $metadata);

			return true;
			
    	} catch(\InstagramAPI\Exception\BadRequestException $e) {
    		
    		return false;
    		
    	}
    	
    }
    
	public function postalbum($mediaFiles, $imgCodes, $caption, $actingAccount) {
	    	
       	try {
    		
    		$ig = new \InstagramAPI\Instagram();
    		$login = $ig->login($actingAccount['account_username'], $actingAccount['account_password']);
			
			foreach($mediaFiles as $index => $mediaFile) {
				
				$imgCode = $imgCodes[$index];
				$data = getimagesize($mediaFile);
				$width = $data[0];
				$height = $data[1];
	
				if(floatval($width/$height) < 0.8) {
					
					$neWidth = 0.8*$height;
					
					if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
						$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile, $height);
					}
					
					$new_file[] = array('type' => 'photo', 'file' => 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile));
				
				} else if(floatval($width/$height) > 1.910) {
	
					$neWidth = 1.910*$height;
					
					if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
						$this->resize($neWidth, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile, $height);
					}

					$new_file[] = array('type' => 'photo', 'file' => 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile));					

				} else {
	
					if(!file_exists('user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile))) {
						$this->resize(1000, 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize', $mediaFile);
					}

					$new_file[] = array('type' => 'photo', 'file' => 'user/'.md5($actingAccount['account_userid']).'/'.$imgCode.'_resize.'.$this->get_extension($mediaFile));						

				}
			
			}

			$ig->timeline->uploadAlbum($new_file, ['caption' => $caption]);

			return true;
			
    	} catch(\InstagramAPI\Exception\BadRequestException $e) {
    		
    		return false;
    		
    	}
    	
    }
    
    public function getFilePath($userid, $media) {
    	
		$dir = new \DirectoryIterator("user/".md5($userid));
		foreach ($dir as $fileinfo) {
		    if (!$fileinfo->isDot()) {
		    	if(preg_match('/'.$media.'/', $fileinfo->getFilename())) {
		    		return "user/".md5($userid)."/".$fileinfo->getFilename();
		    	}
		    }
		}
    	
    }


}
?>