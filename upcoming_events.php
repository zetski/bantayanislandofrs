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
            background-color: #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-weight: bold;
        }
        .event-date {
            font-size: 40px;
            margin: 0;
        }
        .event-month {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .event-year {
            font-size: 16px;
            margin-top: -5px;
        }
        .event-weekdays {
            display: flex;
            justify-content: space-between;
            width: 100%;
            font-size: 14px;
            margin-top: 10px;
            color: #666;
        }
        .event-description {
            font-size: 16px;
            color: #333;
            margin-top: 20px;
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
            // Get date components
            $eventDate = strtotime($row['event_date']);
            $day = date('d', $eventDate);
            $month = date('F', $eventDate);
            $year = date('Y', $eventDate);

            echo '<div class="event-card">';
            
            // Event date
            echo '<div class="event-date">' . $day . '</div>';
            echo '<div class="event-month">' . $month . '</div>';
            echo '<div class="event-year">' . $year . '</div>';

            // Weekday headers
            echo '<div class="event-weekdays">
                    <span>Sun</span> <span>Mon</span> <span>Tue</span> <span>Wed</span>
                    <span>Thu</span> <span>Fri</span> <span>Sat</span>
                  </div>';

            // Event description
            echo '<div class="event-description">so this is a month of events</div>';

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
