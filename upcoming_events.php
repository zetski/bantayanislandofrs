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
        }
        .carousel-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }
        .event-list {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }
        .event-item {
            min-width: 100%;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            box-sizing: border-box;
        }
        .event-item img {
            width: 100%;
            height: 50vh;
            object-fit: cover;
        }
        .event-details {
            padding: 20px;
            text-align: center;
            overflow-y: auto; /* Enable scrolling if content overflows */
            max-height: 40vh; /* Limit height for responsiveness */
        }
        .event-details h3 {
            font-size: 2vw; /* Adjusts font size relative to viewport */
            color: #333;
            margin: 10px 0;
        }
        .event-details p {
            color: #666;
            font-size: 3.5vw; /* Responsive font size */
            line-height: 1.4;
        }
        .event-details .event-date {
            font-weight: bold;
            margin-top: 10px;
            font-size: 3.5vw; /* Adjust date font size */
        }
        .event-details .event-location {
            margin-bottom: 20px;
        }
        .carousel-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }
        .dot {
            width: 10px;
            height: 10px;
            background-color: #ddd;
            border-radius: 50%;
            margin: 0 3px;
            cursor: pointer;
        }
        .dot.active {
            background-color: #333;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .event-details {
                padding: 10px;
            }
            .event-details h3 {
                font-size: 20px; /* Adjust for smaller screens */
            }
            .event-details p, .event-details .event-date {
                font-size: 14px;
            }
            .carousel-dots {
                bottom: 10px; /* Adjust dots position for smaller screens */
            }
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
                    echo '<img src="./uploads/' . basename($row['event_image']) . '" alt="' . $row['event_name'] . '">';
                } else {
                    echo '<img src="./default-image.jpg" alt="Default Image">';
                }

                // Event Details
                echo '<div class="event-details">';
                echo '<h3>' . $row['event_name'] . '</h3>';

                // Display event date and time
                $eventDate = date('F j, Y', strtotime($row['event_date']));
                $eventTime = date('h:i A', strtotime($row['event_time']));
                echo '<p class="event-date"><span class="icon">📅</span> ' . $eventDate . ' at ' . $eventTime . '</p>';

                echo '<p>' . $row['event_description'] . '</p>';
                echo '<p class="event-location"><span class="icon">📍</span> ' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</p>';
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

        // Wrap around the slide index
        if (n >= slides.length) { slideIndex = 0 }
        if (n < 0) { slideIndex = slides.length - 1 }

        // Move the event list to the correct slide
        document.querySelector('.event-list').style.transform = 'translateX(' + (-100 * slideIndex) + 'vw)';

        // Update active dot
        dots.forEach(dot => dot.classList.remove('active'));
        dots[slideIndex].classList.add('active');
    }

    function currentSlide(n) {
        slideIndex = n - 1;
        showSlides(slideIndex);
    }

    // Auto slide every 5 seconds
    setInterval(() => {
        slideIndex++;
        showSlides(slideIndex);
    }, 5000);
</script>

</body>
</html>
