<?php

namespace App;

class Auth {

    public function login($user) {
    
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user->id;

    }
    
    public function loginAdmin($admin) {
    
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin->id;
    
}
    
    public function logout() {
    
      $_SESSION	=	[];
    
      if(ini_get('session.use_cookies')) {
    
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time()	-	4200,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    
      }
}
    
    public function isLoggedIn() {
        return (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false);
}
    
    public function isAdminLoggedIn() {
        return (isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : false);
}

}

?>
