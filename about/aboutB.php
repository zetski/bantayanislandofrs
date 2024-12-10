<?php
$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}
?>
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

        .back-button {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #ff4500; /* Fire orange-red background */
            color: #fff; /* White icon */
            border: none;
            padding: 12px;
            border-radius: 50%;
            font-size: 18px; /* Icon size */
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .back-button i {
            pointer-events: none; /* Prevents the icon from affecting the button's hover */
        }

        .back-button:hover {
            background-color: #ff6347; /* Slightly lighter red-orange on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .back-button:focus {
            outline: none; /* Remove outline when focused */
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

        /* Carousel Dots */
        .carousel-dots {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .carousel-dots .dot {
            width: 10px;
            height: 10px;
            margin: 0 5px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .carousel-dots .dot.active {
            background-color: #f45000;
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
            .header {
                padding: 10px 15px;
            }

            .header h1 {
                font-size: 1.2rem; /* Reduce font size */
            }

            .back-button {
                padding: 8px; /* Reduce padding */
                font-size: 14px; /* Reduce icon size */
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 8px 10px;
            }

            .header h1 {
                font-size: 1rem; /* Further reduce font size */
            }

            .back-button {
                padding: 6px; /* Further reduce padding */
                font-size: 12px; /* Further reduce icon size */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
        <button class="back-button" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
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
                        <img src="../officerimg/Cabrera ID.jpg" alt="Officer 1">
                        <h3>F/INSP NOEL E. CABRERA, MPA</h3>
                        <h6>Acting, Municipal Fire Marshal</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/ursal ID.jpg" alt="Officer 3">
                        <h3>SF02 Elpidio H Ursal Jr</h3>
                        <h6>Chief, Operation / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Gelito ID.jpg" alt="Officer 4">
                        <h3>F03 Arclet M Gelito</h3>
                        <h6>Chief, Admin / Chief IIS</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Giganto ID.jpg" alt="Officer 5">
                        <h3>F02 Jason L Giganto</h3>
                        <h6 style="font-size: 8px">Driver / Supply NCO / Shift A In Charge / Shift Investigator / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Sisles ID.jpg" alt="Officer 6">
                        <h3>F02 Crisanto Y Sisles</h3>
                        <h6>Shift B In-Charge / Shift Investigator / Reserved Driver</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Tamis ID.jpg" alt="Officer 7">
                        <h3>F02 Prince Ricky B Tamis</h3>
                        <h6>Collecting Agent / Survivorship NCO / FSES Cler / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Baroro ID.jpg" alt="Officer 8">
                        <h3>F02 Rey Marvin W Baroro</h3>
                        <h6>First Aider / Driver / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Carabio ID.jpg" alt="Officer 9">
                        <h3>F01 Jayzer S Carabio</h3>
                        <h6>Driver / Petty Cash Custodian / FSI</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Jauculan ID.jpg" alt="Officer 10">
                        <h3>F01 Jaypee O Jauculan</h3>
                        <h6>Reserved Driver / Nozzleman</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Labasbas ID.jpg" alt="Officer 11">
                        <h3>F01 Jerald S Labasbas</h3>
                        <h6>Nozzleman</h6>
                    </div>
                    <div class="officer">
                        <img src="../officerimg/Etcobanez ID.jpg" alt="Officer 12">
                        <h3>F01 Niño P Ectobanez</h3>
                        <h6>Reserved Driver / Nozzleman</h6>
                    </div>
                    <!-- Add other officers here similarly -->
                </div>

                <!-- Carousel Dots -->
                <div class="carousel-dots" id="carousel-dots"></div>
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
                <a href="mailto:bfpsantafe@gmail.com">bantayanbfp@gmail.com</a>
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
        const dotsContainer = document.getElementById('carousel-dots');

        // Create dots based on the number of slides
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (i === currentSlide) dot.classList.add('active');
            dot.addEventListener('click', () => showSlide(i));
            dotsContainer.appendChild(dot);
        }

        function updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentSlide].classList.add('active');
        }

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
            updateDots();
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
