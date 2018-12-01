<?php

namespace App\Models;

use PDO;

class Proxies extends \Core\Model
{

	public function __construct($data = []) {

		foreach($data as $key => $value) {
			$this->$key = $value;
		}

	}

	public function getProxies() {

		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM proxies');

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
				
	}

	public function getNonVerifiedProxies() {
		
		$working = '0';

		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM proxies WHERE working = :working');
			
			$stmt->bindParam(':working', $working, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
				
	}
	
	public function getWorkingProxies() {
		
		$working = '1';
		$userid = '0';

		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM proxies WHERE working = :working AND userid = :userid');
			
			$stmt->bindParam(':working', $working, PDO::PARAM_INT);
			
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
				
	}
	
	public function addProxies() {
		
	  	$text = trim($this->proxies);
		$proxies = explode("\r\n", $text);
		$proxies = array_filter($proxies, 'trim');
		
		$sql = "INSERT INTO proxies (proxy) VALUES ('".$proxies[0]."');";
		if(count($proxies) > 2) {
			for($i=1; $i<count($proxies); $i++) {
				$sql .= "INSERT INTO proxies (proxy) VALUES ('".$proxies[$i]."');";
			}
		}
		
		try {
			
			$db = $this->getDB();
			
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
			
			$stmt = $db->prepare($sql);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
		
	}
	
	public function updateProxyStat($id, $stat) {

		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('UPDATE proxies SET working = :stat WHERE id = :p_id');
			
			$stmt->bindParam(':stat', $stat, PDO::PARAM_INT);
			$stmt->bindParam(':p_id', $id, PDO::PARAM_INT);
			
			$stmt->execute();

			return true;
					
		} catch(PDOException $e) {
			$e->getMessage();
		}
		
	}
	
	public function setAssigned($id, $userid) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('UPDATE proxies SET userid = :userid WHERE id = :p_id');
			
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt->bindParam(':p_id', $id, PDO::PARAM_INT);
			
			$stmt->execute();

			return true;
					
		} catch(PDOException $e) {
			$e->getMessage();
		}
		
	}


}

?>
