<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/r7logo.png" type="img/png">
    <title>Online Fire Reporting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #3a4dd9, #a2b9ff);
            color: #333;
        }

        /* Carousel Container */
        .carousel-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        /* Event List */
        .event-list {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        /* Event Item */
        .event-item {
            min-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
        }

        .event-item img {
            width: 100%;
            height: 60%;
            object-fit: cover;
        }

        /* Event Details */
        .event-details {
            padding: 20px;
            text-align: center;
        }

        .event-details h3 {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }

        .event-details p {
            color: #666;
            margin: 5px 0;
        }

        /* Date and Time Style */
        .event-date-time {
            font-weight: bold;
            color: #333;
        }

        /* Carousel Dots */
        .carousel-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }

        .dot {
            width: 15px;
            height: 15px;
            background-color: #ddd;
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
        }

        .dot.active {
            background-color: #333;
        }
    </style>
</head>
<body>

<!-- Event Carousel -->
<div class="carousel-container">
    <div class="event-list">
        <?php
        include './initialize.php';

        $sql = "SELECT * FROM events_list WHERE event_date >= CURDATE() AND delete_flag = 0 ORDER BY event_date ASC";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="event-item">';
                if ($row['event_image']) {
                    echo '<img src="./uploads/' . basename($row['event_image']) . '" alt="' . $row['event_name'] . '">';
                } else {
                    echo '<img src="./default-image.jpg" alt="Default Image">';
                }
                echo '<div class="event-details">';
                echo '<h3>' . $row['event_name'] . '</h3>';

                // Display event date and time
                $eventDate = date('m/d/Y', strtotime($row['event_date']));
                $eventTime = date('h:i A', strtotime($row['event_time']));
                echo '<p class="event-date-time">' . $eventDate . ' at ' . $eventTime . '</p>';

                // Display event location
                echo '<p class="event-location">' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No upcoming events at the moment.</p>';
        }
        mysqli_close($con);
        ?>
    </div>
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
