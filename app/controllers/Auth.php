<?php 
class Auth extends Controller {
    public static function login($data, $level) {
        $username = $data['username'];
        $password = md5($data['password']);
    
        $user = $level == 'anggota' ? self::model('User')->withCredentials($username, $password) : self::model('Admin_Model')->withCredentials($username, $password, $level);

        if (!$user) {
            return Flasher::setFlash('Username atau password salah', 'danger');
        }
        
        if ($level == 'admin' && $user[0]['f_status'] == 'Tidak Aktif') {
            return Flasher::setFlash('Akun Tidak Aktif', 'danger');
        }
        
        $_SESSION['u_id'] = $user[0]['f_id'];
        $_SESSION['u_name'] = $user[0]['f_nama'];
        $_SESSION['u_rl'] = ($level == 'anggota') ? 'anggota' : $user[0]['f_level'];
        
        Utils::directToRole($_SESSION['u_rl']);
    }
    
    public static function checkHasLoggedIn () {
        if (isset($_SESSION['u_id'])) {
            Utils::directToRole($_SESSION['u_rl']);
        }
    }

    public static function preventUnauthenticated () {
        if (!isset($_SESSION['u_id'])) {
            Utils::navigateTo('../index.php');
        }
    }
    
    public static function logout () {
        Utils::destroySession();
        Utils::navigateTo(BASE_PAGE_URL.'/index.php');
    }

    public static function preventUnauthorized (array $access_owner) {
        if (isset($_SESSION['u_rl'])) {
            if (!in_array($_SESSION['u_rl'], $access_owner)) {
                Utils::directToRole($_SESSION['u_rl']);
            }
        } else {
            self::logout();
        }
    }
}