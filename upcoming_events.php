<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

.carousel-container {
    position: relative;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
}

.carousel-wrapper {
    display: flex;
    width: 300%; /* Allow space for three carousel items */
    transition: transform 0.5s ease;
    height: 100%;
}

.carousel-item {
    min-width: 100vw; /* Ensure each item takes up full width of the viewport */
    height: 100vh;
    box-sizing: border-box;
    position: relative;
}

.event-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.event-details {
    position: absolute;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

.event-details h3 {
    font-size: 32px;
    margin-bottom: 10px;
}

.event-details p {
    font-size: 18px;
    margin: 5px 0;
}

.event-details .event-date, .event-location {
    font-weight: bold;
}

.event-details .event-date {
    margin-top: 10px;
}

.event-details .event-location {
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.icon {
    margin-right: 8px;
    color: #fff;
}

/* Carousel Navigation */
.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1;
}

.nav-btn.left {
    left: 10px;
}

.nav-btn.right {
    right: 10px;
}

/* Carousel Dots */
.carousel-dots {
    position: absolute;
    bottom: 20px;
    width: 100%;
    text-align: center;
    z-index: 1;
}

.dot {
    display: inline-block;
    width: 15px;
    height: 15px;
    margin: 0 5px;
    background-color: #bbb;
    border-radius: 50%;
    cursor: pointer;
}

.dot.active {
    background-color: #fff;
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


unique carousel

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
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
        .event-details .event-date {
            font-weight: bold;
            margin-top: 10px;
        }
        .event-details .event-location {
            margin-bottom: 50px;
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

<div class="carousel-container">
    <div class="event-list">
        <?php
        include './initialize.php';

        $sql = "SELECT * FROM events_list WHERE event_date >= CURDATE() ORDER BY event_date ASC";
        $result = mysqli_query($conn, $sql);

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
                echo '<p class="event-date"><span class="icon">📅</span>' . date('F j, Y', strtotime($row['event_date'])) . '</p>';
                echo '<p>' . $row['event_description'] . '</p>';
                echo '<p class="event-location"><span class="icon">📍</span>' . $row['municipality'] . ', ' . $row['barangay'] . ', ' . $row['sitio'] . '</p>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo '<p>No upcoming events at the moment.</p>';
        }

        mysqli_close($conn);
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



default upcoming events;


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

