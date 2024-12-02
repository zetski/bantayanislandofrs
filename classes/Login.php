<?php
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_error', 1);
        session_start(); // Start session for login attempt tracking
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
    }

    public function login() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_until'] = 0;
        }

        // Check lockout status
        if (time() < $_SESSION['lockout_until']) {
            $remaining_time = $_SESSION['lockout_until'] - time();
            return json_encode(array(
                'status' => 'locked',
                'msg' => "You are banned. Please try again after {$remaining_time} seconds."
            ));
        }

        extract($_POST);

        // Fetch the user based on username
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $storedHash = $user['password'];

            // Check if the password is in MD5 format (32 characters long)
            if (strlen($storedHash) == 32) {
                if (md5($password) === $storedHash) {
                    // Re-hash the password with bcrypt for future logins
                    $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $updateStmt = $this->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                    $updateStmt->bind_param("ss", $newHashedPassword, $username);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    return $this->handleFailedAttempt();
                }
            } else {
                if (!password_verify($password, $storedHash)) {
                    return $this->handleFailedAttempt();
                }
            }

            // Successful login: reset failed attempts and set session data
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_until'] = 0;
            foreach ($user as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }
            $this->settings->set_userdata('login_type', 1);
            return json_encode(array('status' => 'success'));
        } else {
            return $this->handleFailedAttempt();
        }
    }

    private function handleFailedAttempt() {
        $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lockout_until'] = time() + (3 * 60); // Lockout for 3 minutes
            return json_encode(array(
                'status' => 'locked',
                'msg' => "Too many failed attempts. Please try again in 3 minutes."
            ));
        }

        $remaining_attempts = 3 - $_SESSION['login_attempts'];
        return json_encode(array(
            'status' => 'failed',
            'msg' => "Invalid credentials. You have {$remaining_attempts} attempts left."
        ));
    }

    public function logout() {
        if ($this->settings->sess_des()) {
            redirect('admin/login.php');
        }
    }

    public function login_user() {
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * from tutor_list where email = ? and `password` = ? and `status` != 3 and `delete_flag` = 0 ");
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
