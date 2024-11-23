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
		session_start(); // Ensure session is started
	
		// Initialize session-based attempt tracking
		if (!isset($_SESSION['login_attempts'])) {
			$_SESSION['login_attempts'] = 0;
			$_SESSION['last_attempt_time'] = 0;
		}
	
		$current_time = time();
	
		// Check for timeout
		if ($_SESSION['login_attempts'] >= 3) {
			$time_since_last_attempt = $current_time - $_SESSION['last_attempt_time'];
			if ($time_since_last_attempt < 180) { // 3 minutes timeout
				$remaining_time = 180 - $time_since_last_attempt;
				return json_encode([
					'status' => 'timeout',
					'message' => 'Too many failed attempts. Try again in ' . ceil($remaining_time) . ' seconds.'
				]);
			} else {
				// Reset attempts after timeout period
				$_SESSION['login_attempts'] = 0;
			}
		}
	
		// Process login logic
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
	
			if (password_verify($password, $user['password'])) {
				// Reset attempts on success
				$_SESSION['login_attempts'] = 0;
	
				// Set user data in session
				foreach ($user as $k => $v) {
					if (!is_numeric($k) && $k != 'password') {
						$this->settings->set_userdata($k, $v);
					}
				}
				$this->settings->set_userdata('login_type', 1);
	
				return json_encode(['status' => 'success']);
			}
		}
	
		// Failed login: Increment attempts
		$_SESSION['login_attempts']++;
		$_SESSION['last_attempt_time'] = $current_time;
	
		$remaining_attempts = 3 - $_SESSION['login_attempts'];
		return json_encode([
			'status' => 'failed',
			'message' => 'Invalid username or password.',
			'attempts_left' => max($remaining_attempts, 0)
		]);
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
