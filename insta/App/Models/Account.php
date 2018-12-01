<?php

namespace App\Models;

use PDO;
use \App\Controllers\Token;

/**
	Account Model
**/

class Account extends \Core\Model
{

	public function __construct($data = []) {
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function manuallyAddAccount($username, $password, $category, $proxy, $userid) {

				$date = date('Y-m-d H:i:s', time());

				try {

					$db = $this->getDB();

					$stmt = $db->prepare('INSERT INTO accounts (account_username, account_password, account_category, account_proxy, account_userid, account_added) VALUES (:account_username, :account_password, :account_category, :account_proxy, :account_userid, :account_added)');

					$stmt->bindParam(':account_username', $username, PDO::PARAM_STR);
					$stmt->bindParam(':account_password', $password, PDO::PARAM_STR);
					$stmt->bindParam(':account_category', $category, PDO::PARAM_STR);
					$stmt->bindParam(':account_proxy', $proxy, PDO::PARAM_STR);
					$stmt->bindParam(':account_userid', $userid, PDO::PARAM_INT);
					$stmt->bindParam(':account_added', $date, PDO::PARAM_STR);

					$stmt->execute();

					return $db->lastInsertId();

				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				
	}
	
	public function setAccountProxy($accid, $proxy) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('UPDATE accounts SET account_proxy = :account_proxy WHERE id = :u_id');
			
			$stmt->bindParam(':account_proxy', $proxy, PDO::PARAM_STR);
			$stmt->bindParam(':u_id', $accid, PDO::PARAM_INT);
			
			$stmt->execute();

			return true;
					
		} catch(PDOException $e) {
			$e->getMessage();
		}
		
	}
	
	public function addProxies($proxies, $accid, $userid) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE accounts SET account_proxies = :account_proxies WHERE id = :accid AND account_userid = :userid");
			
			$stmt->bindParam(":account_proxies", $proxies, PDO::PARAM_STR);
			
			$stmt->bindParam(':accid', $accid, PDO::PARAM_INT);
			
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
		
	}
	
	public function update_account_data($instaid, $instaname, $instapic, $instfollowers, $instamedia, $instalevel, $accid) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE accounts SET account_id = :account_id, account_name = :account_name, account_profile = :account_profile, account_followers = :account_followers, account_media = :account_media, account_level = :account_level WHERE id = :accid");
			
			$stmt->bindParam(":account_id", $instaid, PDO::PARAM_STR);
			
			$stmt->bindParam(":account_name", $instaname, PDO::PARAM_STR);
			
			$stmt->bindParam(":account_profile", $instapic, PDO::PARAM_STR);
			
			$stmt->bindParam(":account_followers", $instfollowers, PDO::PARAM_INT);
			
			$stmt->bindParam(":account_media", $instamedia, PDO::PARAM_INT);
			
			$stmt->bindParam(":account_level", $instalevel, PDO::PARAM_INT);
			
			$stmt->bindParam(":accid", $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
		
	}

	public function updateUsername($accid, $accusername) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE accounts SET account_username = :account_username WHERE id = :accid");
			
			$stmt->bindParam(":account_username", $accusername, PDO::PARAM_STR);
			
			$stmt->bindParam(":accid", $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
		
	}	

	public function update_account_counts($level, $followers, $accid) {
		
		try {
			
			$db = $this->getDB();

			$stmt = $db->prepare("UPDATE accounts SET account_followers = :account_followers, account_level = :account_level WHERE id = :account_id");
	
			$stmt->bindParam(':account_followers', $followers, PDO::PARAM_INT);
			
			$stmt->bindParam(':account_level', $level, PDO::PARAM_INT);
			
			$stmt->bindParam(':account_id', $accid, PDO::PARAM_INT);
	
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			echo $e->getMessage();
			
		}
		
	}
	
	public function update_account_followers($newid, $accid) {
		
		$system_followers = json_decode($this->getAccountById($accid)['system_followers'], true);
		$system_followers[] = $newid;
		$encoded_followers = json_encode($system_followers);

		try {
			
			$db = $this->getDB();

			$stmt = $db->prepare("UPDATE accounts SET system_followers = :system_followers WHERE id = :account_id");
	
			$stmt->bindParam(':system_followers', $encoded_followers, PDO::PARAM_STR);
			
			$stmt->bindParam(':account_id', $accid, PDO::PARAM_INT);
	
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			
			echo $e->getMessage();
			
		}		
	}
	
	public function usernameExist($username) {
		try {
	
			$db = $this->getDB();
	
			$stmt = $db->prepare("SELECT * FROM accounts WHERE account_username = :uname");
	
			$stmt->bindParam(':uname', $username, PDO::PARAM_STR);
	
			$stmt->execute();
	
			return $stmt->fetch() !== false;
	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function deleteAccount($accid) {

		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('DELETE FROM accounts WHERE id = :accid');
			
			$stmt->bindParam(':accid', $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		
	}
	
	public function getAccountById($accid) {
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('SELECT * FROM accounts WHERE id = :accid');
			
			$stmt->bindParam(':accid', $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function getAccountByCategory($category, $accid) {
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('SELECT * FROM accounts WHERE account_category = :category AND id <> :accid');
			
			$stmt->bindParam(':category', $category, PDO::PARAM_STR);
			
			$stmt->bindParam(':accid', $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}		
	}
	
	/*public function editAccount($accid, $email, $password) {
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare('UPDATE accounts SET account_email = :account_email, account_password = :account_password WHERE id = :accid');
			
			$stmt->bindParam(':account_email', $email, PDO::PARAM_INT);
			
			$stmt->bindParam(':account_password', $password, PDO::PARAM_INT);
			
			$stmt->bindParam(':accid', $accid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}*/
	
	public function getAll($userid) {

		try {

			$db = $this->getDB();

			$stmt = $db->prepare('SELECT * FROM accounts WHERE account_userid = :userid');
			
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			
			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	

}

?>
