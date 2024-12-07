<?php
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_error', 1);
        session_start();
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
    }

    public function login() {
        session_start();
        $max_attempts = 3; // Maximum login attempts
        $timeout_duration = 60; // Timeout duration in seconds
    
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['timeout'] = null;
        }
    
        // Check if user is locked out
        if ($_SESSION['timeout'] && time() < $_SESSION['timeout']) {
            $remaining_time = $_SESSION['timeout'] - time();
            return json_encode([
                'status' => 'error',
                'message' => "Too many failed attempts. Please wait $remaining_time seconds before retrying."
            ]);
        }
    
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $storedHash = $user['password'];
    
            // Verify password
            if ((strlen($storedHash) == 32 && md5($password) === $storedHash) || password_verify($password, $storedHash)) {
                // Reset attempts on successful login
                $_SESSION['login_attempts'] = 0;
                $_SESSION['timeout'] = null;
    
                foreach ($user as $k => $v) {
                    if (!is_numeric($k) && $k != 'password') {
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type', 1);
    
                return json_encode(['status' => 'success']);
            } else {
                $_SESSION['login_attempts']++;
            }
        } else {
            $_SESSION['login_attempts']++;
        }
    
        // Handle attempts and timeout
        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['timeout'] = time() + $timeout_duration;
            return json_encode([
                'status' => 'error',
                'message' => "Too many failed attempts. Please wait $timeout_duration seconds before retrying."
            ]);
        }
    
        $remaining_attempts = $max_attempts - $_SESSION['login_attempts'];
        return json_encode([
            'status' => 'error',
            'message' => "Invalid credentials. You have $remaining_attempts attempts left."
        ]);
    }

    public function logout() {
        if ($this->settings->sess_des()) {
            redirect('admin/login.php');
        }
    }

    public function login_user() {
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * from tutor_list where email = ? and `password` = ? and `status` != 3 and `delete_flag` = 0");
        $password = md5($password);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $res = $result->fetch_array();
            foreach ($res as $k => $v) {
                $this->settings->set_userdata($k, $v);
            }
            $this->settings->set_userdata('login_type', 2);
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Incorrect Email or Password';
        }
        if ($this->conn->error) {
            $resp['status'] = 'failed';
            $resp['_error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    public function logout_user() {
        if ($this->settings->sess_des()) {
            redirect('tutor');
        }
    }
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
    case 'login':
        echo $auth->login();
        break;
    case 'logout':
        echo $auth->logout();
        break;
    case 'login_user':
        echo $auth->login_user();
        break;
    case 'logout_user':
        echo $auth->logout_user();
        break;
    default:
        echo $auth->index();
        break;
}
