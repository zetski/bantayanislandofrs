<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .event-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .event-item {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 350px;
            overflow: hidden;
            text-align: center;
            position: relative;
        }
        .event-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .event-details {
            padding: 20px;
        }
        .event-details h3 {
            font-size: 24px;
            color: #333;
        }
        .event-details p {
            color: #666;
        }
        .event-details .event-date {
            font-weight: bold;
            margin-top: 10px;
        }
        .event-details .event-location {
            margin-bottom: 10px;
        }
        .icon {
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>

<?php
// Include your database connection
include './initialize.php';

// Fetch upcoming events
$sql = "SELECT * FROM events_list WHERE event_date >= CURDATE() ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="event-list">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="event-item">';
        
        // Event Image
        if ($row['event_image']) {
            echo '<img src="./uploads/' . basename($row['event_image']) . '" alt="' . $row['event_name'] . '">';
        } else {
            echo '<img src="./default-image.jpg" alt="Default Image">';
        }

        // Event Details
        echo '<div class="event-details">';
        echo '<h3>' . $row['event_name'] . '</h3>';
        echo '<p class="event-date"><span class="icon">📅</span>' . date('F j, Y', strtotime($row['event_date'])) . '</p>';
        echo '<p>' . $row['event_description'] . '</p>';
        echo '<p class="event-location"><span class="icon">📍</span>' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</p>';
        echo '</div>';

        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>No upcoming events at the moment.</p>';
}

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>

