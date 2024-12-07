<?php
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_errors', 1);
        session_start(); // Only call session_start() once
    }

    public function login() {
        $maxAttempts = 3;
        $timeoutDuration = 60; // 60 seconds
        $currentAttempts = $_SESSION['login_attempts'] ?? 0;

        // Check timeout
        if (isset($_SESSION['timeout']) && time() < $_SESSION['timeout']) {
            $remainingTime = $_SESSION['timeout'] - time();
            echo json_encode([
                'status' => 'error',
                'message' => 'Too many failed attempts. Please wait ' . $remainingTime . ' seconds.',
            ]);
            exit;
        }

        // Reset attempts if timeout passed
        if (isset($_SESSION['timeout']) && time() >= $_SESSION['timeout']) {
            unset($_SESSION['login_attempts'], $_SESSION['timeout']);
            $currentAttempts = 0;
        }

        // Your login validation logic
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['password']);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo json_encode(['status' => 'success']);
            unset($_SESSION['login_attempts'], $_SESSION['timeout']);
        } else {
            $currentAttempts++;
            $_SESSION['login_attempts'] = $currentAttempts;

            if ($currentAttempts >= $maxAttempts) {
                $_SESSION['timeout'] = time() + $timeoutDuration;
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Too many failed attempts. Please wait 1 minute.',
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid credentials. Remaining attempts: ' . ($maxAttempts - $currentAttempts),
                ]);
            }
        }
        exit;
    }

    public function logout() {
        if ($this->settings->sess_des()) {
            redirect('admin/login.php');
        }
    }

    public function login_user() {
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * from tutor_list WHERE email = ? AND `password` = ? AND `status` != 3 AND `delete_flag` = 0");
        $password = md5($password); // Consider using password_hash instead of md5
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

    public function index() {
        echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
    }

    public function __destruct() {
        parent::__destruct();
    }
}

$action = isset($_GET['f']) ? strtolower($_GET['f']) : 'none';
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
?>
