<?php

namespace App\Models;

use PDO;
use \App\Auth;
use \App\Models\Usermod;
use \App\Controllers\Token;
use \App\Controllers\Mail;


class User extends \Core\Model
{

	public $errors = [];
	public $activation_token;

	public function __construct($data = []) {

		foreach($data as $key => $value) {
			$this->$key = $value;
		}

	}

	public function setToken($userid) {
		
		$token = new Token();
		
		$activation_hash = $token->getHash();
		$this->activation_token = $token->getValue();
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE users SET activation_hash = :activation_hash WHERE id = :userid");
			
			$stmt->bindParam(':activation_hash', $activation_hash, PDO::PARAM_STR);
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}
	
	public function authenticateAdmin() {
	
		$admin = $this->findAdminByemail($this->email);
	
		if($admin) {
			if(password_verify($this->password, $admin->password_hash)) {
					return $admin;
			} else {
				$this->errors[] = 'Your password is incorrect!';
			}
		} else {
			$this->errors[] = 'Email does not exist !';
		}
	
	}
	
	public function authenticate() {
	
		$user = $this->findByemail($this->email);
	
		if($user) {
			if(password_verify($this->password, $user->user_password)) {
				return $user;
			} else {
				$this->errors[] = 'Your password is incorrect, please try again !';
			}
		} else {
			$this->errors[] = 'Email does not exist ! please register a new account !';
		}
	
	}
	
	public function sendActivationMail($params = []) {
	
		$mail = new Mail();

		$htmlemail = "";
	
		$email_header = file_get_contents("../App/Views/Emails/header.html");
		$htmlemail .= $email_header;
	
		$email_content = "
		<tr><td align=\"center\" bgcolor=\"#fbfcfd\">
			<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr><td align=\"center\">
					<!-- padding --><div style=\"height: 60px; line-height: 60px; font-size: 10px;\"> </div>
					<div style=\"line-height: 44px;\">
						<font face=\"Arial, Helvetica, sans-serif\" size=\"5\" color=\"#57697e\" style=\"font-size: 34px;\">
						<span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">
							Please Activate Your Email
						</span></font>
					</div>
					<!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"> </div>
				</td></tr>
				<tr><td align=\"center\">
					<div style=\"line-height: 24px;\">
						<font face=\"Arial, Helvetica, sans-serif\" size=\"4\" color=\"#57697e\" style=\"font-size: 15px;\">
						<span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">
							Use the link below to activate your email<br>link will expire in 24 days
						</span></font>
					</div>
					<!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"> </div>
				</td></tr>
				<tr><td align=\"center\">
					<div style=\"line-height: 24px;\">
						<a href=\"".\App\Config::SITE_PATH."/users/activate/".$this->activation_token."\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\">
							<font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" size=\"3\" color=\"#596167\">
								<img src=\"https://dabuttonfactory.com/button.png?t=Activate&f=Roboto-Bold&ts=20&tc=fff&tshs=1&tshc=000&w=200&h=50&c=4&bgt=unicolored&bgc=215a60\" alt=\"Activate\" border=\"0\" style=\"display: block;\" /></font></a>
							<br><br>Text link : ".\App\Config::SITE_PATH."/users/activate/".$this->activation_token."
					</div>
					<!-- padding --><div style=\"height: 60px; line-height: 60px; font-size: 10px;\"> </div>
				</td></tr>
			</table>
		</td></tr>
		<!--content 1 END-->
		";
		$htmlemail .= $email_content;
	
		$email_footer = file_get_contents("../App/Views/Emails/footer.html");
		$htmlemail .= $email_footer;
	
		if(empty($params)) {
			
			if($mail->send($this->email, $this->name, "Activate your Account", $htmlemail)) {
		
					return true;
		
			}			
			
		} else {
			
			if($mail->send($params['email'], $params['name'], "Activate your Account", $htmlemail)) {
		
					return true;
		
			}			
			
		}
	
	}
	
	public function activate($token_value, $userid) {
		
		$token = new Token($token_value);
		$hashed_token = $token->getHash();
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE users SET email_verified = 1, activation_hash = '' WHERE activation_hash = :hashed_token");
			
			$stmt->bindParam(":hashed_token", $hashed_token, PDO::PARAM_STR);
			
			$stmt->execute();
			
			if($this->activate_trial($userid)) {
	
				return true;
				
			} else {
				
				return false;
			}
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
	}
	
	public function activate_trial($userid) {
		
		if($this->is_trial_elligible($userid)) {
			
			$trial_start = date('Y-m-d H:i:s', time());
			$trial_ends = date('Y-m-d H:i:s', strtotime('+2 day', strtotime($trial_start)));
			
			try {
				
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE users SET is_trial = 1, trial_start = :trial_start, trial_ends = :trial_ends WHERE id = :user_id");
			
			$stmt->bindParam(":trial_start", $trial_start, PDO::PARAM_STR);
			$stmt->bindParam(":trial_ends", $trial_ends, PDO::PARAM_STR);
			$stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;				
				
				
			} catch(PDOException $e) {
				
				$e->getMessage();
				
			}
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function setProxy($userid, $proxy) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("UPDATE users SET user_proxy = :user_proxy WHERE id = :userid");
			
			$stmt->bindParam(':user_proxy', $proxy, PDO::PARAM_STR);
			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return true;
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
	}

	public function save() {
	
		$this->validate();
	
		if(empty($this->errors)) {

			$password_hash = password_hash($this->acc_pass, PASSWORD_DEFAULT);

			/*$token = new Token();
	
			$activation_hash = $token->getHash();
			$this->activation_token = $token->getValue();
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];*/
			
			try {
	
				$db = $this->getDB();
	
				$stmt = $db->prepare("UPDATE accounts SET account_email = :account_email, account_password = :account_password, account_category = :account_category");
	
				$stmt->bindParam(':account_email', $this->acc_email, PDO::PARAM_STR);
				$stmt->bindParam(':account_password', $password_hash, PDO::PARAM_STR);
				$stmt->bindParam(':account_category', $this->acc_cat, PDO::PARAM_STR);

				$stmt->execute();
	
				return true;
	
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	
		return false;
	
	}
	
	public function saveNewUser() {
	
		$this->validate();
	
		if(empty($this->errors)) {

			$password_hash = password_hash($this->acc_pass, PASSWORD_DEFAULT);
			$full_name = $this->f_name.' '.$this->l_name;

			/*$token = new Token();
	
			$activation_hash = $token->getHash();
			$this->activation_token = $token->getValue();
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];*/
			
			try {
	
				$db = $this->getDB();
	
				$stmt = $db->prepare("INSERT INTO users (user_email, user_password, user_name, user_timezone) VALUES (:user_email, :user_password, :user_name, :user_timezone)");
	
				$stmt->bindParam(':user_email', $this->acc_email, PDO::PARAM_STR);
				$stmt->bindParam(':user_password', $password_hash, PDO::PARAM_STR);
				$stmt->bindParam(':user_name', $full_name, PDO::PARAM_STR);
				$stmt->bindParam(':user_timezone', $this->time_zone, PDO::PARAM_STR);

				$stmt->execute();
	
				return true;
	
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	
		return false;
	
	}
	
	public function validate() {
	
		//Email Adress
		if(filter_var($this->acc_email, FILTER_VALIDATE_EMAIL) === false) {
			$this->errors[] = 'Emails is Invalid !';
		}
	
		if($this->emailExists($this->acc_email)) {
			$this->errors[] = 'This email is already in use !';
		}

		if($this->f_name == '' || $this->l_name == '') {
			$this->errors[] = 'First/Last Name fields are required !';
		}
		
		//Password
		if($this->acc_pass_confirm != $this->acc_pass) {
			$this->errors[] = 'Password must match confirmation';
		}
	
		if(strlen($this->acc_pass) < 6) {
			$this->errors[] = 'Please enter at least 6 characters for password !';
		}
	
		if(preg_match('/.*[a-z]+.*/i', $this->acc_pass) == 0) {
			$this->errors[] = 'Password must contain at least 1 letter';
		}
	
		if(preg_match('/.*\d+.*/i', $this->acc_pass) == 0) {
			$this->errors[] = 'Password must contain at least 1 number';
		}
	}
	
	public function get_user_details($userid) {

		try{
			$db = $this->getDB();

			$stmt = $db->prepare("SELECT * FROM users WHERE id = :userid");

			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function getAll() {

		try {

			$db = $this->getDB();

			$stmt = $db->query('SELECT * FROM users');

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	
	public function trial_ends($userid) {

		try{
			$db = $this->getDB();

			$stmt = $db->prepare("UPDATE users set is_trial = 2 WHERE id = :userid");

			$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

			$stmt->execute();

			return true;

		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	protected function is_trial_elligible($userid) {
		
		try {
			
			$db = $this->getDB();
			
			$stmt = $db->prepare("SELECT * FROM users WHERE id = :user_id");
			
			$stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if($user_data['is_trial'] == 0) {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
			
		} catch(PDOException $e) {
			
			$e->getMessage();
			
		}
		
	}
	
	protected function emailExists($email) {
		try {
	
			$db = $this->getDB();
	
			$stmt = $db->prepare("SELECT * FROM users WHERE user_email = :email");
	
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
	
			$stmt->execute();
	
			return $stmt->fetch() !== false;
	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	protected function findByemail($email) {
		try {
	
			$db = $this->getDB();
	
			$stmt = $db->prepare("SELECT * FROM users WHERE user_email = :email");
	
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
	
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
	
			$stmt->execute();
	
			return $stmt->fetch();
	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	protected function findAdminByemail($email) {
		try {
	
			$db = $this->getDB();
	
			$stmt = $db->prepare("SELECT * FROM admins WHERE email = :email");
	
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
	
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
	
			$stmt->execute();
	
			return $stmt->fetch();
	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	

}

?>
