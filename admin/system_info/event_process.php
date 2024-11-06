<?php
// Handle form submission in event_process.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize the database connection
    include '../initialize.php'; // Adjust this depending on your setup

    // Get POST data and sanitize inputs
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $sitio = mysqli_real_escape_string($conn, $_POST['sitio']);

    // Default empty event image
    $event_image = '';

    // Handling file upload for event image
    if (!empty($_FILES['event_image']['name'])) {
        $file_name = $_FILES['event_image']['name'];
        $file_tmp = $_FILES['event_image']['tmp_name'];
        $upload_path = '../uploads/'; // Make sure this folder is writable

        // Create the uploads directory if it doesn't exist
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $new_file_name = time() . "_" . basename($file_name); // Rename file to avoid conflicts
        $file_destination = $upload_path . $new_file_name;

        // Move the uploaded file to the destination
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $event_image = $new_file_name; // Save only the file name in the database
        } else {
            // Return JSON error if file upload fails
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            exit();
        }
    }

    // Insert the event data into the database using a prepared statement
    $stmt = $conn->prepare("INSERT INTO events_list (event_name, event_description, event_date, municipality, barangay, sitio, event_image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $event_name, $event_description, $event_date, $municipality, $barangay, $sitio, $event_image);

    if ($stmt->execute()) {
        // Return success response as JSON
        echo json_encode(['status' => 'success', 'message' => 'Event has been added successfully.']);
    } else {
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $conn->error]);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
    exit();
}
?>
