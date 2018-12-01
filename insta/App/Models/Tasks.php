<?php

namespace App\Models;

use PDO;

class Tasks extends \Core\Model

{

	protected $data = [];

	public function __construct($data = []) {
		$this->data = $data;
	}

	public function addTasks($task_action, $userid, $accid, $done) {
		$date = date("Y-m-d H:i:s");
		$elets = (isset($this->data['lists']) ? json_encode($this->data['lists']) : json_encode(array()));
		$message = (isset($this->data['message']) ? json_encode($this->data['message']) : '');
		$category = (isset($this->data['category']) ? $this->data['category'] : '');
		
		if($done == 1) {
			$fuids_done = $elets;
		} else {
			$fuids_done = '';
		}
		
		$typeid = $this->getTypeId($task_action);
		$t_id = $typeid['id'];
		$task_name = $typeid['task_name'];
		$task_delay = $this->data['delay'];
		$t_max_total = (isset($this->data['job_max']) ? $this->data['job_max'] : '0');
		$schedule = (isset($this->data['schedule']) ? strtotime($this->data['schedule']) : '');
		$t_max_day = (isset($this->data['max']) ? $this->data['max'] : '0');
		$task_threads = (isset($this->data['threads']) ? $this->data['threads'] : '0');
		

		try {

			$db = $this->getDB();
			
			$stmt = $db->prepare('INSERT INTO tasks (task_name, task_fuids_done, task_fuids_done_today, task_action, task_userid, task_accid, task_typeid, task_message, task_max_total, task_max_day, task_delay, task_threads, task_schedule, task_scrap_elements, task_category, task_update) VALUES (:task_name, :task_fuids_done, :task_fuids_done_today, :task_action, :task_userid, :task_accid, :task_typeid, :task_message, :task_max_total, :task_max_day, :task_delay, :task_threads, :task_schedule, :task_scrap_elements, :task_category, :task_update)');

			$stmt->bindParam(':task_action', $task_action, PDO::PARAM_STR);
			$stmt->bindParam(':task_name', $task_name, PDO::PARAM_STR);
			$stmt->bindParam(':task_fuids_done', $fuids_done, PDO::PARAM_STR);
			$stmt->bindParam(':task_fuids_done_today', $fuids_done, PDO::PARAM_STR);
			$stmt->bindParam(':task_userid', $userid, PDO::PARAM_INT);
			$stmt->bindParam(':task_accid', $accid, PDO::PARAM_INT);
			$stmt->bindParam(':task_typeid', $t_id, PDO::PARAM_INT);
			$stmt->bindParam(':task_message', $message, PDO::PARAM_STR);
			$stmt->bindParam(':task_max_total', $t_max_total, PDO::PARAM_INT);
			$stmt->bindParam(':task_max_day', $t_max_day, PDO::PARAM_INT);
			$stmt->bindParam(':task_delay', $task_delay, PDO::PARAM_INT);
			$stmt->bindParam(':task_threads', $task_threads, PDO::PARAM_INT);
			$stmt->bindParam(':task_schedule', $schedule, PDO::PARAM_STR);
			$stmt->bindParam(':task_scrap_elements', $elets, PDO::PARAM_STR);
			$stmt->bindParam(':task_category', $category, PDO::PARAM_STR);
			$stmt->bindParam(':task_update', $date, PDO::PARAM_STR);

			$stmt->execute();

		} catch (PDOException $e) {
			echo $e->getMessage();
		}		

		
		return true;
				
	}
	
	public function editTask() {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('UPDATE tasks SET task_name = :task_name, task_delay = :task_delay, task_threads = :task_threads, task_max_total = :task_max_total, task_max_day = :task_max_day WHERE id = :task_id');

			$stmt->bindParam(':task_name', $this->data['name'], PDO::PARAM_STR);
			
			$stmt->bindParam(':task_delay', $this->data['delay'], PDO::PARAM_STR);
			
			$stmt->bindParam(':task_threads', $this->data['threads'], PDO::PARAM_INT);
			
			$stmt->bindParam(':task_max_total', $this->data['max'], PDO::PARAM_INT);
			
			$stmt->bindParam(':task_max_day', $this->data['max_day'], PDO::PARAM_INT);
			
			$stmt->bindParam(':task_id', $this->data['task_id'], PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}
	
	public function editTaskStatus($action) {
		
		$stop = (($action == "stop") ? "1" : "0");
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE tasks SET task_stop = :task_stop WHERE id = :task_id");
			
			$stmt->bindParam(':task_stop', $stop, PDO::PARAM_INT);
			
			$stmt->bindParam(':task_id', $this->data['taskid'], PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}
	
	public function deleteTask($task_id) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('DELETE FROM tasks WHERE id = :task_id');
			
			$stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}

	public function getTypeId($task_action) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("SELECT id,task_name FROM tasks_types WHERE task_url = :task_url");
			
			$stmt->bindParam(':task_url', $task_action, PDO::PARAM_STR);
			
			$stmt->execute();
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}
	
    public function getTaskTypeId($id) {
    		
    		try {
    
    			$db = $this->getDB();
    
    			$stmt = $db->prepare('SELECT * FROM tasks_types WHERE id = :t_id');
    			
    			$stmt->bindParam(':t_id', $id, PDO::PARAM_INT);
    			
    			$stmt->execute();
    
    			$results = $stmt->fetch(PDO::FETCH_ASSOC);
    
    			return $results['task_url'];
    
    		} catch (PDOException $e) {
    			echo $e->getMessage();
    		}
    	}
    	
	public function getAllTaskTypes() {
    		
    		try {
    
    			$db = $this->getDB();
    
    			$stmt = $db->prepare('SELECT * FROM tasks_types');
    			
    			$stmt->execute();
    
    			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    			return $results;
    
    		} catch (PDOException $e) {
    			echo $e->getMessage();
    		}
    	}
    	
    public function getTaskId($id) {
    		
    		try {
    
    			$db = $this->getDB();
    
    			$stmt = $db->prepare('SELECT * FROM tasks WHERE id = :t_id');
    			
    			$stmt->bindParam(':t_id', $id, PDO::PARAM_INT);
    			
    			$stmt->execute();
    
    			$results = $stmt->fetch(PDO::FETCH_ASSOC);
    
    			return $results;
    
    		} catch (PDOException $e) {
    			echo $e->getMessage();
    		}
    	}
	
	public function getAllTasks($accid) {

		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM tasks WHERE task_accid = :task_accid');
			
			$stmt->bindParam(':task_accid', $accid, PDO::PARAM_INT);
			
			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function getAllTasksByAction($accid, $task_action) {
			
			try {
				
				$db = $this->getDB();
				
				$stmt = $db->prepare("SELECT * FROM tasks WHERE task_action = :task_action AND task_accid = :task_accid");
				
				$stmt->bindParam(':task_action', $task_action, PDO::PARAM_STR);
				
				$stmt->bindParam(':task_accid', $accid, PDO::PARAM_INT);
				
				$stmt->execute();
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
				
			} catch(PDOException $e) {
				
				$e->getMessage();
				
			}
		}
	
	public function getTasks() {
		$t_s = '';
		
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM tasks WHERE task_stop = 0 AND task_done = 0 AND task_schedule = :t_s ORDER BY task_update ASC');

			$stmt->bindParam(':t_s', $t_s, PDO::PARAM_STR);

			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getSchedules() {
		$t_s = '';
		
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM tasks WHERE task_stop = 0 AND task_done = 0 AND task_schedule <> :t_s ORDER BY task_update ASC');

			$stmt->bindParam(':t_s', $t_s, PDO::PARAM_STR);

			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function update_task_fuids($fuids, $taskid) {
	
			try {
				
				$db = $this->getDB();
	
				$stmt = $db->prepare("UPDATE tasks SET task_fuids_queue = :task_fuids_queue WHERE id = :task_id");
		
				$stmt->bindParam(':task_fuids_queue', $fuids, PDO::PARAM_STR);

				$stmt->bindParam(':task_id', $taskid, PDO::PARAM_INT);
		
				$stmt->execute();
				
				return true;
				
			} catch(PDOException $e) {
				
				echo $e->getMessage();
				
			}		
		}
		
	public function update_single_task_done($actingccid, $taskid) {
			
			$fuids_done = json_decode($this->getTaskId($taskid)['task_fuids_done'], true);
			$fuids_done_today = json_decode($this->getTaskId($taskid)['task_fuids_done_today'], true);
			
			$fuids_done[] = $actingccid;
			$fuids_done_today[] = $actingccid;
			
			$encoded_fuids = json_encode($fuids_done);
			$encoded_fuids_done_today = json_encode($fuids_done_today);
	
			try {
				
				$db = $this->getDB();
	
				$stmt = $db->prepare("UPDATE tasks SET task_fuids_done = :task_fuids_done, task_fuids_done_today = :task_fuids_done_today WHERE id = :task_id");
		
				$stmt->bindParam(':task_fuids_done', $encoded_fuids, PDO::PARAM_STR);
				
				$stmt->bindParam(':task_fuids_done_today', $encoded_fuids_done_today, PDO::PARAM_STR);
				
				$stmt->bindParam(':task_id', $taskid, PDO::PARAM_INT);
		
				$stmt->execute();
				
				return true;
				
			} catch(PDOException $e) {
				
				echo $e->getMessage();
				
			}		
		}
	
	public function update_task_done($mediaid, $actingccid, $taskid) {
		
		$fuids_done = json_decode($this->getTaskId($taskid)['task_fuids_done'], true);
		$fuids_done[] = $actingccid;
		$encoded_fuids = json_encode($fuids_done);

		try {
			
			$db = $this->getDB();

			$stmt = $db->prepare("UPDATE tasks SET task_fuids_done = :task_fuids_done, task_fuids_done_today = :task_fuids_done_today WHERE id = :task_id");
	
			$stmt->bindParam(':task_fuids_done', $encoded_fuids, PDO::PARAM_STR);
			
			$stmt->bindParam(':task_fuids_done_today', $encoded_fuids, PDO::PARAM_STR);
			
			$stmt->bindParam(':task_id', $taskid, PDO::PARAM_INT);
	
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			echo $e->getMessage();
			
		}		
	}
	
	public function update_processing_task($task, $taskid) {
		$date = date("Y-m-d H:i:s");
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('UPDATE tasks SET task_processing = :task_processing, task_update = :task_update WHERE id = :taskid');

			$stmt->bindParam(':task_processing', $task, PDO::PARAM_INT);
			
			$stmt->bindParam(':task_update', $date, PDO::PARAM_STR);
			
			$stmt->bindParam(':taskid', $taskid, PDO::PARAM_INT);

			$stmt->execute();

			return true;

		} catch (PDOException $e) {
			
			echo $e->getMessage();
			
		}		
		
	}
	
	public function validateTask($taskid) {
		
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('UPDATE tasks SET task_done = 1 WHERE id = :taskid');

			$stmt->bindParam(':taskid', $taskid, PDO::PARAM_STR);

			$stmt->execute();

			return true;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}	    
		}
		
	public function getRrecordById($rid) {
		
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM records WHERE record_id = :record_id');

			$stmt->bindParam(':record_id', $rid, PDO::PARAM_STR);

			$stmt->execute();

			$results = $stmt->fetch(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function addRecord($rid, $value) {
		
		try {

			$db = $this->getDB();

			$stmt = $db->prepare('INSERT INTO records (record_id, record_value) VALUES (:record_id, :record_value)');

			$stmt->bindParam(':record_id', $rid, PDO::PARAM_STR);
			
			$stmt->bindParam(':record_value', $value, PDO::PARAM_STR);

			$stmt->execute();

			return true;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


}
?>