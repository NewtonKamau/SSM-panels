<?php
namespace Core;

use \App\Models\Account;
use \App\Models\User;
use \App\Auth;

abstract class Controller
{

	protected $route_params = [];

	protected $instagram;

	protected $account;
	
	protected $user;
	
	protected $data;
	
	protected $user_details;
	
	protected $token;
	
	protected $query_hash;
	
	protected $auth;
	
	public $insta_login;
	
	

	public function __construct($route_params) {
		$this->route_params = $route_params;
		$this->account = new Account();
		$this->user = new User();
		$this->auth = new Auth();
		\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
		
		$this->query_hash = 'ded47faa9a1aaded10161a2ff32abb6b';
		$this->token = 'AQB59DkrYrVotYyZtFQADTH7pH8XXDVyZKFYLk3anHBaXFr6emGI4o9ivPvHZHi6KpGo8shGevJFcN-QArCyCZNEpCt5r6DkewI1Tws70-2ZOA';
		
		$this->instagram = new \Larabros\Elogram\Client('95fb285abf67461480bb027932ee8acd', 'ccf5bdf3d70f4db99729338113495066', null, 'https://insta-insta-malawidivani00.c9users.io/accounts/index');
		
	}

	public function __call($name, $args) {

		$method = $name."Action";

		if(method_exists($this, $method)) {
			if($this->before() !== false) {
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		} else {
			// echo "Method $method not found in the controller".get_class($this);
			throw new \Exception("Method $method not found in controller ".get_class($this));
		}
	}
	
	protected function post_insta($url, $fields, $cookie_file, $proxy, $header = null) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if(!empty($header)) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, realpath("user/DigiCertHighAssuranceEVRootCA.crt"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		if($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, trim($proxy));
		}
		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie_file));
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie_file));
		$result = curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);


		curl_close($ch);

		return array('header'	=>	$header,'body'	=>	$body);

		}
		
	protected function visit($cookie_file, $proxy, $header = null) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/accounts/login/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if(!empty($header)) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, realpath("user/DigiCertHighAssuranceEVRootCA.crt"));
		if($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, trim($proxy));
		}
		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie_file));

		$result = curl_exec($ch);
		curl_close($ch);

		if($result) {
		return $result;
		}

	}
	
	protected function link_visit($url, $cookie_file, $proxy, $header = null) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if(!empty($header)) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, realpath("user/DigiCertHighAssuranceEVRootCA.crt"));
		if($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, trim($proxy));
		}
		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie_file));

		$result = curl_exec($ch);
		curl_close($ch);

		if($result) {
		return $result;
		}

	}
	
	protected function silent_visit($url, $cookie_file, $proxy, $referer = "") {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($referer != "") {
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, realpath("user/DigiCertHighAssuranceEVRootCA.crt"));
		if($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, trim($proxy));
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie_file));
		$result = curl_exec($ch);
		curl_close($ch);
		
		if($result) { 
		return $result;
		}
		
	}
	
	protected function recursive_array_search($needle,$haystack) {
		
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
        
    }
    
	 return false;
	}
	
	protected function isValidProxy($proxy) {
	    if (!is_string($proxy) && !is_array($proxy)) {
	        return false;        
	    }
	
	    try {
	        $client = new \GuzzleHttp\Client();
	        $res = $client->request('GET', 'http://www.instagram.com', 
	                                [
	                                    "verify" => SSL_ENABLED,
	                                    "timeout" => 10,
	                                    "proxy" => $proxy
	                                ]);
	        $code = $res->getStatusCode();
	        echo $code;exit;
	    } catch (\Exception $e) {
	        return false;
	    }
	
	    return $code == 200;
	}
	
	protected function check_proxy($proxy) {
		
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, 'https://www.facebook.com');
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
		curl_setopt($ch, CURLOPT_PROXY, trim($proxy));

		$result = curl_exec($ch);

		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		if($httpcode == 200) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function resize_image($file, $w, $h, $crop=FALSE) {
		
	    list($width, $height) = getimagesize($file);
	    $r = $width / $height;
	    if ($crop) {
	        if ($width > $height) {
	            $width = ceil($width-($width*abs($r-$w/$h)));
	        } else {
	            $height = ceil($height-($height*abs($r-$w/$h)));
	        }
	        $newwidth = $w;
	        $newheight = $h;
	    } else {
	        if ($w/$h > $r) {
	            $newwidth = $h*$r;
	            $newheight = $h;
	        } else {
	            $newheight = $w/$r;
	            $newwidth = $w;
	        }
	    }
	    $src = imagecreatefromjpeg($file);
	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	    return $dst;
	    
	}
	
	public function resize($newWidth, $targetFile, $originalFile, $calcHeight = false) {
	
	    $info = getimagesize($originalFile);
	    $mime = $info['mime'];
	
	    switch ($mime) {
	            case 'image/jpeg':
	                    $image_create_func = 'imagecreatefromjpeg';
	                    $image_save_func = 'imagejpeg';
	                    $new_image_ext = 'jpg';
	                    break;
	
	            case 'image/png':
	                    $image_create_func = 'imagecreatefrompng';
	                    $image_save_func = 'imagepng';
	                    $new_image_ext = 'png';
	                    break;
	
	            case 'image/gif':
	                    $image_create_func = 'imagecreatefromgif';
	                    $image_save_func = 'imagegif';
	                    $new_image_ext = 'gif';
	                    break;
	
	            default: 
	                    throw new Exception('Unknown image type.');
	    }
	
	    $img = $image_create_func($originalFile);
	    list($width, $height) = getimagesize($originalFile);
		if($calcHeight === false) {
		    $newHeight = ($height / $width) * $newWidth;
		} else {
			$newHeight = $calcHeight;
		}
		
	    $tmp = imagecreatetruecolor($newWidth, $newHeight);
	    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
	
	    if (file_exists($targetFile)) {
	            unlink($targetFile);
	    }
	    $image_save_func($tmp, "$targetFile.$new_image_ext");
	}

	public function get_extension($file) {
		
	 $extension = explode(".", $file);
	 return $extension[1] ? $extension[1] : false;
	 
	}

	protected function redirect($url) {
		header('Location: https://'.$_SERVER['HTTP_HOST'].$url,	true,	303);
	}

	protected function before() {
	}

	protected function after() {
	}

}

?>
