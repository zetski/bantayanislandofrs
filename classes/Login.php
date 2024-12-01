<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login() {
		extract($_POST);
	
		// Sanitize input
		$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
		$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
	
		// Start session to track login attempts
		session_start();
	
		// Initialize login attempts tracking if not already set
		if (!isset($_SESSION['login_attempts'])) {
			$_SESSION['login_attempts'] = [];
		}
	
		// Check if the username is locked
		if (isset($_SESSION['login_attempts'][$username])) {
			$attemptData = $_SESSION['login_attempts'][$username];
	
			// Check if user is still in cooldown period
			// Check if user is still in cooldown period
			if ($attemptData['attempts'] >= 3 && time() - $attemptData['last_attempt'] < 300) { // 300 seconds = 5 minutes
				return json_encode([
					'status' => 'locked',
					'message' => 'Too many login attempts. Please try again after 5 minutes.'
				]);
			}
		}
	
		// Query database for user
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			$storedHash = $user['password'];
	
			// Verify password
			if ((strlen($storedHash) == 32 && md5($password) === $storedHash) || password_verify($password, $storedHash)) {
				// Successful login: Reset login attempts
				unset($_SESSION['login_attempts'][$username]);
	
				// Set session data
				foreach ($user as $k => $v) {
					if (!is_numeric($k) && $k != 'password') {
						$this->settings->set_userdata($k, $v);
					}
				}
				$this->settings->set_userdata('login_type', 1);
	
				return json_encode(['status' => 'success']);
			}
		}
	
		// Failed login attempt
		if (!isset($_SESSION['login_attempts'][$username])) {
			$_SESSION['login_attempts'][$username] = ['attempts' => 0, 'last_attempt' => time()];
		}
	
		$_SESSION['login_attempts'][$username]['attempts']++;
		$_SESSION['login_attempts'][$username]['last_attempt'] = time();
	
		// Lock user if attempts exceed the limit
		if ($_SESSION['login_attempts'][$username]['attempts'] >= 3) {
			return json_encode([
				'status' => 'locked',
				'message' => 'Too many login attempts. Please try again after 3 minutes.'
			]);
		}
	
		return json_encode(['status' => 'incorrect', 'message' => 'Invalid username or password.']);
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function login_user(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from tutor_list where email = ? and `password` = ? and `status` != 3 and `delete_flag` = 0 ");
		$password = md5($password);
		$stmt->bind_param('ss',$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('login_type',2);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function logout_user(){
		if($this->settings->sess_des()){
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
