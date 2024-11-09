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
            color: #333;
            background: linear-gradient(135deg, #3a4dd9, #a2b9ff);
        }

        /* Header Section */
        .header {
            text-align: center;
            padding: 50px;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
        }

        .header h1 {
            font-size: 36px;
            font-weight: bold;
        }

        .header p {
            font-size: 18px;
            margin: 10px 0 20px;
        }

        .header .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .header .buttons a {
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            background-color: #ff6b6b;
        }

        .header .buttons a:hover {
            background-color: #ff4d4d;
        }

        /* Countdown Timer */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 30px;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0;
        }

        .countdown div {
            text-align: center;
        }

        .countdown span {
            display: block;
            font-size: 28px;
        }

        /* Contact Information */
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 50px;
            padding: 20px 0;
            color: #fff;
            font-size: 16px;
        }

        /* Event Carousel */
        .carousel-container {
            position: relative;
            width: 100vw;
            height: 70vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            margin-top: 20px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }

        .event-list {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        .event-item {
            min-width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .event-item img {
            width: 100%;
            height: 60%;
            object-fit: cover;
        }

        .event-details {
            padding: 20px;
            text-align: center;
        }

        .event-details h3 {
            font-size: 24px;
            color: #333;
        }

        .event-details p {
            color: #666;
        }

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

<!-- Header Section -->
<div class="header">
    <h1>Join Us for the Online Fire Reporting System Launch</h1>
    <p>Get ready for virtual sessions in October 2023 to learn more about fire safety and reporting.</p>
    <div class="buttons">
        <a href="#register">Register</a>
        <a href="#watch-video">Watch Video</a>
    </div>
</div>

<!-- Countdown Timer -->
<div class="countdown">
    <div>
        <span>301</span> Days
    </div>
    <div>
        <span>06</span> Hours
    </div>
    <div>
        <span>13</span> Minutes
    </div>
    <div>
        <span>21</span> Seconds
    </div>
</div>

<!-- Contact Information -->
<div class="contact-info">
    <div><span>📧</span> fire.reporting@example.com</div>
    <div><span>📍</span> 100 Main Street, NYC</div>
    <div><span>📞</span> +1 (555) 123-4567</div>
</div>

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
