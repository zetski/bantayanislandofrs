<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Station</title>
    <style>
        /* General Body Reset */
        body {
            margin: 0;
            padding: 0;
        }

        /* Carousel Styling */
        .carousel-item > img {
            object-fit: cover;
            height: 300px; /* Adjust to the desired carousel height */
            width: 100%;
        }

        .carousel-inner {
            height: 300px; /* Matches the carousel image height */
        }

        /* Styling for the button */
        .btn {
            color: #fff;
            margin-top: 20px;
            background-color: #f46000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:focus, .btn:hover {
            outline: none;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        /* Horizontal Rule Styling */
        hr {
            width: 8em;
            height: 3px;
            background-color: navy;
            opacity: 1;
            border: none;
            margin: 20px auto;
        }

        /* Welcome Section Styling */
        .welcome-container {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 24px;
            font-weight: bold;
            line-height: 1.5;
            padding: 20px; /* Adds padding around the content */
        }

        /* Adjust spacing for the card */
        .card {
            margin-top: 20px;
        }

    </style>
</head>
<body>
<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleControls" class="carousel slide bg-dark" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                            $upload_path = "uploads/banner";
                            if (is_dir(base_app . $upload_path)): 
                                $file = scandir(base_app . $upload_path);
                                $_i = 0;
                                foreach ($file as $img):
                                    if (in_array($img, array('.', '..')))
                                        continue;
                                    $_i++;
                        ?>
                        <div class="carousel-item <?php echo $_i == 1 ? "active" : '' ?>">
                            <img src="<?php echo validate_image($upload_path . '/' . $img) ?>" alt="<?php echo $img ?>">
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10 col-md-11 col-sm-11">
                <div class="card card-outline rounded-0">
                    <div class="card-body">
                        <div class="container-fluid">
                            <center>
                                <hr>
                            </center>
                            <!-- Dynamic Content -->
                            <div class="welcome-container">
                                <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
                            </div>
                            <!-- Button -->
                            <div>
                                <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
