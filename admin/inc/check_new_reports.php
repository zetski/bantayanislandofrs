<?php
// Assuming session and database are already initialized
header('Content-Type: application/json');

// Fetch admin's municipality from POST data
$municipality = $_POST['municipality'] ?? null;

if ($municipality) {
    $query = $conn->query("
        SELECT COUNT(id) as new_count 
        FROM `request_list` 
        WHERE `status` = 0 
        AND `municipality` = '$municipality'
    ");

    $result = $query->fetch_assoc();
    echo json_encode(['new_count' => $result['new_count']]);
} else {
    echo json_encode(['new_count' => 0]);
}
?>
