<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/r7logo.png" type="image/png">
    <title>Online Fire Reporting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4);
        }
        .carousel-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }
        .event-list {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }
        .event-item {
            min-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #333;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            overflow: hidden;
            margin: 20px;
        }
        .event-item img {
            width: 100%;
            height: 60%;
            object-fit: cover;
            border-bottom: 2px solid #ddd;
        }
        .event-details {
            padding: 20px;
            text-align: center;
            font-size: 18px;
        }
        .event-details h3 {
            font-size: 28px;
            color: #444;
            margin-bottom: 10px;
        }
        .event-details p {
            color: #666;
            line-height: 1.5;
        }
        .event-details .event-date, .event-details .event-location {
            font-weight: bold;
            margin-top: 10px;
        }
        .carousel-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }
        .dot {
            width: 12px;
            height: 12px;
            background-color: #ddd;
            border-radius: 50%;
            margin: 0 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .dot.active {
            background-color: #ff5858;
        }
    </style>
</head>
<body>

<div class="carousel-container">
    <div class="event-list">
        <?php
        include './initialize.php';

        $sql = "SELECT * FROM events_list WHERE event_date >= CURDATE() AND delete_flag = 0 ORDER BY event_date ASC";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="event-item">';
                
                // Event Image
                if ($row['event_image']) {
                    echo '<img src="./uploads/' . basename($row['event_image']) . '" alt="' . htmlspecialchars($row['event_name']) . '">';
                } else {
                    echo '<img src="./default-image.jpg" alt="Default Image">';
                }

                // Event Details
                echo '<div class="event-details">';
                echo '<h3>' . htmlspecialchars($row['event_name']) . '</h3>';

                // Display event date and time
                $eventDate = date('F j, Y', strtotime($row['event_date']));
                $eventTime = date('h:i A', strtotime($row['event_time']));
                echo '<p class="event-date">📅 ' . $eventDate . ' at ' . $eventTime . '</p>';

                echo '<p>' . htmlspecialchars($row['event_description']) . '</p>';
                echo '<p class="event-location">📍 ' . htmlspecialchars($row['municipality']) . ', ' . htmlspecialchars($row['barangay']) . ', ' . htmlspecialchars($row['sitio']) . '</p>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo '<p>No upcoming events at the moment.</p>';
        }

        mysqli_close($con);
        ?>
    </div>

    <!-- Carousel Dots -->
    <div class="carousel-dots">
        <?php
        $num_events = mysqli_num_rows($result);
        for ($i = 0; $i < $num_events; $i++) {
            echo '<div class="dot" onclick="currentSlide(' . ($i+1) . ')"></div>';
        }
        ?>
    </div>
</div>

<script>
    let slideIndex = 0;
    showSlides(slideIndex);

    function showSlides(n) {
        let slides = document.querySelectorAll('.event-item');
        let dots = document.querySelectorAll('.dot');

        if (n >= slides.length) { slideIndex = 0 }
        if (n < 0) { slideIndex = slides.length - 1 }

        document.querySelector('.event-list').style.transform = 'translateX(' + (-100 * slideIndex) + 'vw)';

        dots.forEach(dot => dot.classList.remove('active'));
        dots[slideIndex].classList.add('active');
    }

    function currentSlide(n) {
        slideIndex = n - 1;
        showSlides(slideIndex);
    }

    setInterval(() => {
        slideIndex++;
        showSlides(slideIndex);
    }, 5000);
</script>

</body>
</html>
