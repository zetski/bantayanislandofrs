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
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .events-container {
            width: 80%;
            max-width: 1200px;
            text-align: center;
        }
        h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .event-card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .event-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .event-details {
            padding: 15px;
        }
        .event-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .event-description {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .event-location, .event-date {
            font-size: 14px;
            color: #333;
            margin: 10px 0;
            font-weight: bold;
        }
        .calendar {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .calendar h2 {
            font-size: 24px;
            margin: 0;
        }
        .calendar p {
            font-size: 14px;
            color: #333;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="events-container">
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

                // Display event date and time
                $eventDate = date('F j, Y', strtotime($row['event_date']));
                $eventTime = date('h:i A', strtotime($row['event_time']));
                echo '<div class="event-date"><span class="icon">📅</span> ' . $eventDate . ' at ' . $eventTime . '</div>';

                echo '<div class="event-location"><span class="icon">📍</span> ' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</div>';

                // Calendar Highlight (simplified)
                echo '<div class="calendar">';
                echo '<h2>' . date('j', strtotime($row['event_date'])) . '</h2>';
                echo '<p>' . date('F Y', strtotime($row['event_date'])) . '</p>';
                echo '</div>';

                echo '</div>'; // Close event-details
                echo '</div>'; // Close event-card
            }
        } else {
            echo '<p>No upcoming events at the moment.</p>';
        }

        mysqli_close($con);
        ?>
    </div>
</div>

</body>
</html>
