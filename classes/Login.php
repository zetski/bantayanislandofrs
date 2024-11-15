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
	public function login(){
		extract($_POST);
	
		// Fetch the user based on username only
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			$storedHash = $user['password'];
	
			// Check if the password is in MD5 format (32 characters long)
			if (strlen($storedHash) == 32) {
				// Verify with MD5
				if (md5($password) === $storedHash) {
					// Re-hash the password with bcrypt for future logins
					$newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
					$updateStmt = $this->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
					$updateStmt->bind_param("ss", $newHashedPassword, $username);
					$updateStmt->execute();
					$updateStmt->close();
				} else {
					// Incorrect password
					return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * FROM users WHERE username = '$username'"));
				}
			} else {
				// Verify with password_verify for bcrypt or other compatible algorithms
				if (!password_verify($password, $storedHash)) {
					// Incorrect password
					return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * FROM users WHERE username = '$username'"));
				}
			}
	
			// Successful login: set session data
			foreach ($user as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_userdata($k, $v);
				}
			}
			$this->settings->set_userdata('login_type', 1);
			return json_encode(array('status' => 'success'));
		} else {
			// User not found
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * FROM users WHERE username = '$username'"));
		}
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
