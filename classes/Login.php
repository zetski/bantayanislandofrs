<?php
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_errors', 1);
        session_start();

        // Initialize session variables for login attempts and timeout
        if (!isset($_SESSION['remaining_attempts'])) {
            $_SESSION['remaining_attempts'] = 3;
        }
        if (!isset($_SESSION['lockout_time'])) {
            $_SESSION['lockout_time'] = null;
        }
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
    }

    public function login() {
        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
            exit;
        }

        $current_time = time();

        // Check if user is locked out
        if ($_SESSION['lockout_time'] && $current_time < $_SESSION['lockout_time']) {
            $remaining_time = $_SESSION['lockout_time'] - $current_time;
            echo json_encode([
                'status' => 'locked',
                'message' => "Too many failed attempts. Try again in $remaining_time seconds."
            ]);
            exit;
        }

        // Sanitize and validate input
        $username = $this->sanitize_input($_POST['username'] ?? '');
        $password = $this->sanitize_input($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
            exit;
        }

        // Fetch user from the database
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $storedHash = $user['password'];

            // Check password validity
            if ((strlen($storedHash) == 32 && md5($password) === $storedHash) || password_verify($password, $storedHash)) {
                // If password matches, reset attempts and set session data
                $_SESSION['remaining_attempts'] = 3;
                $_SESSION['lockout_time'] = null;

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['district'] = $user['district'];

                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
                exit;
            } else {
                $this->decrement_attempts();
            }
        } else {
            $this->decrement_attempts();
        }
    }

    private function decrement_attempts() {
        if (!isset($_SESSION['remaining_attempts'])) {
            $_SESSION['remaining_attempts'] = 3;
        }

        $_SESSION['remaining_attempts']--;

        if ($_SESSION['remaining_attempts'] <= 0) {
            $_SESSION['lockout_time'] = time() + (3 * 60); // Lockout for 3 minutes
            echo json_encode([
                'status' => 'locked',
                'message' => 'Too many failed login attempts. You are locked out for 3 minutes.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'remaining_attempts' => $_SESSION['remaining_attempts']
            ]);
        }
        exit;
    }

    private function sanitize_input($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    public function logout() {
        if ($this->settings->sess_des()) {
            redirect('admin/login.php');
        }
    }

    public function login_user() {
        // Similar logic for user login can go here
    }

    public function logout_user() {
        if ($this->settings->sess_des()) {
            redirect('tutor');
        }
    }
}

// Action routing
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
    case 'login':
        $auth->login();
        break;
    case 'logout':
        $auth->logout();
        break;
    case 'login_user':
        $auth->login_user();
        break;
    case 'logout_user':
        $auth->logout_user();
        break;
    default:
        $auth->index();
        break;
}
