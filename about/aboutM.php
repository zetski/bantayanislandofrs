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
            background-image: url('../officerimg/firebg.webp');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        /* Container for the whole page */
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: transparent;
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
            max-width: 500px;
            overflow: hidden;
            background-color: transparent;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease;
            width: 100%;
        }

        .officer {
            min-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }

        .officer img {
            width: 300px;
            height: 300px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .officer h3 {
            margin-top: 10px;
            font-size: 1.5rem;
            color: #333;
            text-align: center;
        }

        .officer h6 {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-top: 5px;
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
            .officer img {
                width: 200px;
                height: 200px;
            }

            .officer h3 {
                font-size: 1.2rem;
            }

            .officer h6 {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
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
                <div class="carousel" id="carousel">
                    <div class="officer">
                        <img src="../officerimg/mel.jpg" alt="Officer 1">
                        <h3>F01 Meljan Niño Salmasan</h3>
                        <h6>FSES Clerk / Shift A Crew / Nozzleman</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/lor.jpg" alt="Officer 2">
                        <h3>F01 Loreto G Villacin Jr</h3>
                        <h6>Admin Clerk / FSI / Shift B Crew / Nozzleman</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/rex.jpg" alt="Officer 3">
                        <h3>F01 Rex I Egnora</h3>
                        <h6 style="font-size: 8px">Shift A Driver / Investigator / First Adviser / Operation Clerk / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/ed.jpg" alt="Officer 2">
                        <h3>F02 JR Ed E Villacampa</h3>
                        <h6 style="font-size: 8px">C, Admin / Supply NCO / Investigator / Survivorship NCO / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/ter.jpg" alt="Officer 2">
                        <h3>F03 Teresito M Chavez Jr</h3>
                        <h6>Chief / Operation / Chief, IIS</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/gwen.jpg" alt="Officer 2">
                        <h3>SF01 Gwendolyn P Placencia</h3>
                        <h6>Chief, FSES / Collecting Agent</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/ren.jpg" alt="Officer 2">
                        <h3>SF03 Renato C Veliganio</h3>
                        <h6>OIC, Municipal Fire Marshal</h6>
                    </div>
                    <!-- Add other officers here similarly -->
                </div>
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
                <a href="mailto:bfpsantafe@gmail.com">madridejosbfp@gmail.com</a>
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
        const carousel = document.getElementById('carousel');
        const totalSlides = document.querySelectorAll('.officer').length;

        // Swipe functionality
        let startX = 0;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const change = startX - touch.clientX;

            if (change > 50) {
                nextSlide();
                startX = touch.clientX;
            } else if (change < -50) {
                prevSlide();
                startX = touch.clientX;
            }
        });

        function showSlide(index) {
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
