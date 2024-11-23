<?php
// Include your database connection and settings here
require_once '../initialize.php'; // Update with your DB connection file

$admin_municipality = $_settings->userdata('district');
$new_reports_query = $conn->query("
    SELECT COUNT(id) as count 
    FROM `request_list` 
    WHERE `status` = 0 
    AND `municipality` = '$admin_municipality'
");

$result = $new_reports_query->fetch_assoc();
echo json_encode(['new_reports_count' => $result['count']]);
