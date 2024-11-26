<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_team(){
		$_POST['members'] = addslashes(htmlspecialchars($_POST['members']));
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `team_list` where `code` = '{$code}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Team Code already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `team_list` set {$data} ";
		}else{
			$sql = "UPDATE `team_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$aid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['aid'] = $aid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Team successfully saved.";
			else
				$resp['msg'] = " Team successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_team(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `team_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Team successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	//Delete Events
	function delete_event() {
		global $conn;  // Ensure this uses the global database connection if not within a class
	
		// Sanitize and extract event ID from POST request
		$id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';
	
		if (empty($id)) {
			$resp['status'] = 'error';
			$resp['message'] = 'No event ID provided.';
			return json_encode($resp);
		}
	
		// Update delete_flag to mark the event as deleted
		$sql = "UPDATE events_list SET delete_flag = 1 WHERE id = '$id'";
		$delete = $conn->query($sql);
	
		if ($delete) {
			$resp['status'] = 'success';
			$resp['message'] = 'Event has been deleted successfully.';
		} else {
			$resp['status'] = 'error';
			$resp['message'] = 'Database Error: ' . $conn->error;
		}
	
		return json_encode($resp);
	}
	
	
	function save_event() {
		// Sanitize and extract form data
		extract($_POST);
	
		$event_name = $this->conn->real_escape_string($event_name);
		$event_description = $this->conn->real_escape_string($event_description);
		$event_date = $this->conn->real_escape_string($event_date);
		$event_time = $this->conn->real_escape_string($event_time); // Sanitize event_time
		$municipality = $this->conn->real_escape_string($municipality);
		$barangay = $this->conn->real_escape_string($barangay);
		$sitio = $this->conn->real_escape_string($sitio);
	
		// Default empty event image
		$event_image = '';
	
		// Handle file upload
		if (!empty($_FILES['event_image']['name'])) {
			$file_name = $_FILES['event_image']['name'];
			$file_tmp = $_FILES['event_image']['tmp_name'];
			$upload_path = '../uploads/';
	
			// Ensure upload directory exists
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0755, true);
			}
	
			$new_file_name = time() . "_" . basename($file_name); // Rename file to avoid conflicts
			$file_destination = $upload_path . $new_file_name;
	
			// Move uploaded file to destination
			if (move_uploaded_file($file_tmp, $file_destination)) {
				$event_image = $new_file_name; // Save file name in database
			} else {
				// Handle file upload failure
				$resp['status'] = 'error';
				$resp['message'] = 'File upload failed';
				return json_encode($resp);
				exit();
			}
		}
	
		// Prepare SQL query for inserting or updating event
		$data = "event_name = '$event_name', event_description = '$event_description', event_date = '$event_date', event_time = '$event_time', municipality = '$municipality', barangay = '$barangay', sitio = '$sitio', event_image = '$event_image'";
	
		if (empty($id)) {
			// Insert new event
			$sql = "INSERT INTO events_list SET $data";
		} else {
			// Update existing event
			$sql = "UPDATE events_list SET $data WHERE id = $id";
		}
	
		$save = $this->conn->query($sql);
	
		if ($save) {
			// Handle successful save
			$resp['status'] = 'success';
			$resp['message'] = empty($id) ? 'Event has been added successfully.' : 'Event has been updated successfully.';
		} else {
			// Handle database error
			$resp['status'] = 'error';
			$resp['message'] = 'Database Error: ' . $this->conn->error;
		}
	
		return json_encode($resp);
	}
	
	
	function save_request() {
		// Sanitize input
		if (isset($_POST['message'])) {
			$_POST['message'] = addslashes(htmlspecialchars($_POST['message']));
		}
	
		// Generate a unique code if id is empty
		if (empty($_POST['id'])) {
			$datePrefix = date("Ymd");  // Use the current date in YYYYMMDD format
			$sequenceNumber = 1;       // Start with an initial sequence number
	
			while (true) {
				// Generate a candidate code using a sequence number
				$candidateCode = sprintf("%s-%04d", $datePrefix, $sequenceNumber);
				
				// Check if the candidate code already exists in the database
				$check = $this->conn->query("SELECT id FROM `request_list` WHERE `code` = '{$candidateCode}'")->num_rows;
				
				if ($check > 0) {
					// If the code exists, increment the sequence number and try again
					$sequenceNumber++;
				} else {
					// If the code does not exist, set it and break the loop
					$_POST['code'] = $candidateCode;
					break;
				}
			}
		}
	
		// Handle file upload
		$image_path = null;
		if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
			$fileTmpPath = $_FILES['image']['tmp_name'];
			$fileName = $_FILES['image']['name'];
			$fileSize = $_FILES['image']['size'];
			$fileType = $_FILES['image']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
	
			$allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
			if (in_array($fileExtension, $allowedfileExtensions)) {
				$uploadFileDir = '../uploads/';
				if (!is_dir($uploadFileDir)) {
					mkdir($uploadFileDir, 0777, true);
				}
				$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
				$dest_path = $uploadFileDir . $newFileName;
	
				if (move_uploaded_file($fileTmpPath, $dest_path)) {
					$_POST['image'] = $dest_path;
				} else {
					$resp['status'] = 'failed';
					$resp['err'] = 'Failed to move uploaded file.';
					return json_encode($resp);
				}
			} else {
				$resp['status'] = 'failed';
				$resp['err'] = 'Invalid file extension.';
				return json_encode($resp);
			}
		}
	
		// Prepare data for insertion or update
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			// Exclude the 'id' and 'location' fields
			if (!in_array($k, array('id', 'location'))) {
				if (!empty($data)) $data .= ",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		// Insert or update data in the database
		if (empty($id)) {
			$sql = "INSERT INTO `request_list` SET {$data}";
		} else {
			$sql = "UPDATE `request_list` SET {$data} WHERE id = '{$id}'";
		}
	
		$save = $this->conn->query($sql);
		if ($save) {
			$tid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['tid'] = $tid;
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('request_sent', $code);
			} else {
				$resp['msg'] = "Request successfully updated.";
				$this->settings->set_flashdata('success', "Request has been updated successfully.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
	
		return json_encode($resp);
	}

	public function delete_request() {
		global $conn;
		$id = $_POST['id'];
		
		// Identify the page from which the request is deleted (e.g., 'index')
		$deleted_from = 'index';
		
		// Fetch the report details first
		$qry = $conn->query("SELECT * FROM request_list WHERE id = $id");
		$row = $qry->fetch_assoc();
	
		if ($row) {
			// Store the entire row as JSON in deleted_reports
			$deleted_reports = $conn->real_escape_string(json_encode($row));
	
			// Mark as deleted, store original data in deleted_reports, and track deletion page
			$update_qry = $conn->query("UPDATE request_list SET deleted_reports = '$deleted_reports', status = 5, deleted_from = '$deleted_from' WHERE id = $id");
	
			if ($update_qry) {
				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['status' => 'error', 'message' => $conn->error]); // Error reporting
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Report not found.']);
		}
	}
	
	public function restore_request() {
		header('Content-Type: application/json'); // Set content type to JSON
	
		// Check if 'id' is set in POST data
		if (!isset($_POST['id'])) {
			echo json_encode(['stats' => 'failed', 'error' => 'ID not provided.']);
			return;
		}
	
		extract($_POST); // Extract POST variables
		$id = intval($id); // Sanitize input
	
		// Retrieve the deleted_from value before restoring
		$deleted_from_query = $this->conn->query("SELECT deleted_from FROM request_list WHERE id = '{$id}'");
		$deleted_from = $deleted_from_query->fetch_assoc()['deleted_from'] ?? 'index';
	
		// Soft restore by setting deleted_reports and deleted_from to NULL
		$restore = $this->conn->query("UPDATE request_list SET deleted_reports = NULL, deleted_from = NULL, status = 0 WHERE id = '{$id}'");
	
		// Prepare the response array
		$resp = [];
		if ($restore) {
			$resp['stats'] = 'success';
			$resp['deleted_from'] = $deleted_from; // Include the deleted_from value for redirection
			$this->settings->set_flashdata('success', "Request successfully restored.");
		} else {
			$resp['stats'] = 'failed';
			$resp['error'] = $this->conn->error; // Capture any database error
		}
	
		echo json_encode($resp); // Echo out the JSON response
	}

	public function delete_permanently() {
		header('Content-Type: application/json');
	
		// Check if 'id' is set in POST data
		if (!isset($_POST['id'])) {
			echo json_encode(['status' => 'failed', 'error' => 'ID not provided.']);
			return;
		}
	
		extract($_POST);
		$id = intval($id); // Sanitize input
	
		// Perform the permanent delete from the request_list table
		$delete = $this->conn->query("DELETE FROM request_list WHERE id = '{$id}'");
	
		if ($delete) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Request permanently deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error; // Capture any database error
		}
	
		echo json_encode($resp);
	}
	
	function assign_team(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `request_list` set `status`  = 1, team_id = '{$team_id}' where id = '{$id}'");
		if($update){
			$history = $this->conn->query("INSERT INTO `history_list` set `request_id` ='{$id}', `status` = 1, `remarks` = 'Request has been assign to a fire control team.' ");
			if($history){
				$this->settings->set_flashdata("success", 'Request has been assign to a team.');
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function take_action(){
		extract($_POST);
		$remarks = addslashes(htmlspecialchars($remarks));
		$update = $this->conn->query("UPDATE `request_list` set `status`  = {$status} where id = '{$id}'");
		if($update){
			$history = $this->conn->query("INSERT INTO `history_list` set `request_id` ='{$id}', `status` = {$status}, `remarks` = '{$remarks}' ");
			if($history){
				$this->settings->set_flashdata("success", 'Request\'s Status has been updated successfully.');
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	//officers functions
	function save_officer() {
		extract($_POST);
		
		// Escape input variables to prevent SQL injection
		$lastname = $this->conn->real_escape_string($officer_lastname);
		$firstname = $this->conn->real_escape_string($officer_firstname);
		$middlename = $this->conn->real_escape_string($officer_middlename);
		$position = $this->conn->real_escape_string($officer_position);
		
		// Prepare image uploads
		$image_paths = [];
		if (!empty($_FILES['officer_images']['name'][0])) {
			$upload_path = "../uploads/";
			if (!is_dir(base_app . $upload_path)) {
				mkdir(base_app . $upload_path, 0777, true);
			}
			
			foreach ($_FILES['officer_images']['tmp_name'] as $key => $tmp_name) {
				$file_name = time() . "_" . $_FILES['officer_images']['name'][$key];
				$file_path = $upload_path . $file_name;
				if (move_uploaded_file($tmp_name, base_app . $file_path)) {
					$image_paths[] = $file_path;
				}
			}
		}
		
		$images = implode(",", $image_paths); // Convert array to string for saving
		$data = "`lastname` = '{$lastname}', `firstname` = '{$firstname}', `middlename` = '{$middlename}', `position` = '{$position}', `image` = '{$images}'";
		
		if (empty($id)) {
			$sql = "INSERT INTO `officers` SET {$data}";
		} else {
			$sql = "UPDATE `officers` SET {$data} WHERE id = '{$id}'";
		}
		
		$save = $this->conn->query($sql);
		
		if ($save) {
			$resp['status'] = 'success';
			$resp['msg'] = empty($id) ? "New officer successfully saved." : "Officer details successfully updated.";
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		
		if ($resp['status'] == 'success') {
			$this->settings->set_flashdata('success', $resp['msg']);
		}
		return json_encode($resp);
	}

	function delete_officer() {
		extract($_POST);
	
		$qry = $this->conn->query("DELETE FROM `officers` WHERE id = '{$id}'");
		if ($qry) {
			$resp['status'] = 'success';
			$resp['msg'] = "Officer successfully deleted.";
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
	
		return json_encode($resp);
	}

	function get_officers() {
		$qry = $this->conn->query("SELECT * FROM `officers` ORDER BY `lastname` ASC");
		$data = [];
		while ($row = $qry->fetch_assoc()) {
			$data[] = $row;
		}
		return json_encode($data);
	}

	function save_inquiry(){
		$_POST['message'] = addslashes(htmlspecialchars($_POST['message']));
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inquiry_list` set {$data} ";
		}else{
			$sql = "UPDATE `inquiry_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," Your Inquiry has been sent successfully. Thank you!");
			else
				$this->settings->set_flashdata('success'," Inquiry successfully updated");
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_inquiry(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inquiry_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Inquiry has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_team':
		echo $Master->save_team();
	break;
	case 'delete_team':
		echo $Master->delete_team();
	break;
	case 'save_request':
		echo $Master->save_request();
	break;
	case 'delete_request':
		echo $Master->delete_request();
	break;
	case 'assign_team':
		echo $Master->assign_team();
	break;
	case 'take_action':
		echo $Master->take_action();
	break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
	break;
	case 'delete_inquiry':
		echo $Master->delete_inquiry();
	break;
	case 'delete_event';
	echo $Master->delete_event();
	break;
	case 'save_event';
		echo $Master->save_event();
	break;
	case 'delete_permanently';
	echo $Master->delete_permanently();
	break;
	case 'save_officer';
	echo $Master->save_officer();
	break;
	case 'delete_officer';
	echo $Master->delete_officer();
	break;
	case 'get_officers';
	echo $Master->get_officers();
	break;
	case 'restore_request': // Add this case for restoring requests
        echo $Master->restore_request();
        break;
	default:
		// echo $sysset->index();
		break;
}