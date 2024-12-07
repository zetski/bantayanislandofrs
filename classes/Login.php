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
        
        // Initialize session variables for login attempts and timeout
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 3;
        }
        if (!isset($_SESSION['timeout'])) {
            $_SESSION['timeout'] = null;
        }
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
    }

    public function login() {
        $current_time = time();
        
        // Check if user is locked out
        if ($_SESSION['timeout'] && $current_time < $_SESSION['timeout']) {
            $remaining_time = $_SESSION['timeout'] - $current_time;
            return json_encode([
                'status' => 'locked', 
                'message' => "You are locked out. Try again in $remaining_time seconds."
            ]);
        }

        // Process login
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $storedHash = $user['password'];

            // Handle MD5 or bcrypt password verification
            if (strlen($storedHash) == 32 && md5($password) === $storedHash) {
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $updateStmt = $this->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newHashedPassword, $username);
                $updateStmt->execute();
                $updateStmt->close();
            } elseif (!password_verify($password, $storedHash)) {
                return $this->handleFailedLogin();
            }

            // Successful login: Reset login attempts and set session data
            $_SESSION['login_attempts'] = 3;
            $_SESSION['timeout'] = null;

             // Update 'last_login' to 'Online' in the database
                $updateLoginStatusStmt = $this->conn->prepare("UPDATE users SET role = 'Online' WHERE username = ?");
                $updateLoginStatusStmt->bind_param("s", $username);
                $updateLoginStatusStmt->execute();
                $updateLoginStatusStmt->close();

            foreach ($user as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }
            $this->settings->set_userdata('login_type', 1);

            return json_encode(['status' => 'success']);
        } else {
            return $this->handleFailedLogin();
        }
    }

    private function handleFailedLogin() {
        $_SESSION['login_attempts']--;

        if ($_SESSION['login_attempts'] <= 0) {
            $_SESSION['timeout'] = time() + (3 * 60); // Set 3-minute lockout
            return json_encode([
                'status' => 'locked', 
                'message' => "You are locked out for 3 minutes."
            ]);
        } else {
            return json_encode([
                'status' => 'error', 
                'attempts_left' => $_SESSION['login_attempts']
            ]);
        }
    }

    public function logout() {
        // Check if user is logged in and session variable exists (assuming username is stored in session)
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];  // Or $_SESSION['user_id'] if you're storing user ID
            
            // Update user's role to 'Offline' in the database
            $updateRoleStmt = $this->conn->prepare("UPDATE users SET role = 'Offline' WHERE username = ?");
            $updateRoleStmt->bind_param("s", $username);
            $updateRoleStmt->execute();
            $updateRoleStmt->close();
        }
    
        // Destroy the session and clear session data
        session_unset();
        session_destroy();
        
        // Prevent caching of the login page and other sensitive pages
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        // Redirect to login page
        header("Location: " . base_url . "admin/login.php");
        exit();
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
