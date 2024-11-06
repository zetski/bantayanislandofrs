<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="img/r7logo.png" type="img/png">
    <title>Online Fire Reporting System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-image: url('./officerimg/firebg.webp');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        /* Container for the whole page */
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
        }

        /* Header */
        .header {
            background-color: #f45000;
            color: white;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header .back-button {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            margin-right: auto;
        }

        .header h1 {
            flex: 1;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Content Section */
        .content {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 50px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 30px;
            border-radius: 8px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .mission, .vision {
            font-size: 1.8rem;
            font-weight: bold;
            color: #f45000;
            margin-bottom: 10px;
            text-align: center;
        }

        .content p {
            font-size: 1rem;
            color: #555;
            max-width: 600px;
            text-align: center;
        }

        /* Officers Carousel Section */
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 350px;
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease;
        }

        .officer {
            min-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .officer img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #f45000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .officer h3 {
            margin-top: 10px;
            font-size: 1.2rem;
            color: #333;
            text-align: center;
        }

        /* Carousel buttons */
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .carousel-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        /* Footer */
        .footer {
            background-color: #333;
            padding: 20px 10px;
            color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-size: 1rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .footer .contact-item i {
            font-size: 1.2rem;
        }

        .footer a {
            color: #ff4600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #ff8c00;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.2rem;
            }

            .mission, .vision {
                font-size: 1.5rem;
            }

            .content p {
                font-size: 0.9rem;
            }

            .officer img {
                width: 100px;
                height: 100px;
            }

            .footer {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .mission, .vision {
                font-size: 1.2rem;
            }

            .footer .contact-item {
                font-size: 0.9rem;
            }

            .footer .contact-item i {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Back Button -->
        <header class="header">
            <a href="/ofrs/index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> 
            </a>
            <h1>Online Fire Reporting System</h1>
        </header>

        <!-- Content Section -->
        <div class="content">
            <!-- Mission and Vision Section -->
            <div class="mission">Mission</div>
            <p>Prevent and suppress destructive fires, investigate their causes, enforce fire codes and other related laws, and respond to man-made and natural disasters and other emergencies.</p>
            <div class="vision">Vision</div>
            <p>A modern fire service fully capable of ensuring a fire-safe nation by 2034.</p>

            <!-- Officers Carousel Section -->
            <div class="carousel-container">
                <button class="carousel-btn prev-btn" onclick="prevSlide()">&#10094;</button>
                <div class="carousel" id="carousel">
                    <div class="officer">
                        <img src="../officerimg/aspin.jpg" alt="Officer 1">
                        <h3>Officer 1</h3>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/dlaw.jpg" alt="Officer 2">
                        <h3>Officer 2</h3>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/gear5.jpg" alt="Officer 3">
                        <h3>Officer 3</h3>
                    </div>
                </div>
                <button class="carousel-btn next-btn" onclick="nextSlide()">&#10095;</button>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>09481752040</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <a href="mailto:bantayancentral@gmail.com">bantayancentral@gmail.com</a>
            </div>
            <div class="contact-item">
                <i class="fab fa-facebook"></i>
                <a href="https://facebook.com" target="_blank">facebook.com</a>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Suba, Bantayan, Cebu</span>
            </div>
        </footer>
    </div>

    <script>
        let currentSlide = 0;

        function showSlide(index) {
            const carousel = document.getElementById('carousel');
            const totalSlides = document.querySelectorAll('.officer').length;
            
            if (index >= totalSlides) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = totalSlides - 1;
            } else {
                currentSlide = index;
            }
            
            const offset = -currentSlide * 100;
            carousel.style.transform = `translateX(${offset}%)`;
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }
    </script>
</body>
</html>
