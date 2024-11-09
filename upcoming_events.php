<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/r7logo.png" type="img/png">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            font-size: 28px;
            color: #333;
            margin-top: 20px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 20px;
            width: 100%;
        }
        .event-card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .event-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .event-details {
            padding: 10px;
            text-align: center;
        }
        .event-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .event-description {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .event-location, .event-time {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .calendar {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 0 0 15px 15px;
            width: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .calendar h2 {
            font-size: 36px;
            margin: 0;
            color: #333;
        }
        .calendar p {
            font-size: 14px;
            color: #333;
            margin: 2px 0;
        }
    </style>
</head>
<body>

<h1>Upcoming Events</h1>
<div class="events-grid">
    <?php
    include './initialize.php';

    $sql = "SELECT * FROM events_list WHERE event_date >= CURDATE() AND delete_flag = 0 ORDER BY event_date ASC";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="event-card">';
            
            // Event Image
            if ($row['event_image']) {
                echo '<img src="./uploads/' . basename($row['event_image']) . '" alt="' . $row['event_name'] . '">';
            } else {
                echo '<img src="./default-image.jpg" alt="Default Image">';
            }

            // Event Details
            echo '<div class="event-details">';
            echo '<div class="event-name">' . $row['event_name'] . '</div>';
            echo '<div class="event-description">' . $row['event_description'] . '</div>';
            echo '<div class="event-location">📍 ' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</div>';
            echo '<div class="event-time">⏰ ' . date('h:i A', strtotime($row['event_time'])) . '</div>';
            echo '</div>'; // Close event-details

            // Calendar Highlight (with day and month)
            $eventDate = strtotime($row['event_date']);
            echo '<div class="calendar">';
            echo '<h2>' . date('d', $eventDate) . '</h2>';
            echo '<p>' . date('F Y', $eventDate) . '</p>';
            echo '<p>' . date('l', $eventDate) . '</p>';
            echo '</div>';

            echo '</div>'; // Close event-card
        }
    } else {
        echo '<p>No upcoming events at the moment.</p>';
    }

    mysqli_close($con);
    ?>
</div>

</body>
</html>
