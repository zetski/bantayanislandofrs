<style>
    body {
        padding-top: 10px;
        margin-top: 40px;
    }
    .carousel-item > img {
        object-fit: cover;
        width: 100%;
        height: 20em; /* Adjust the height to your desired value */
    }
    #carouselExampleControls .carousel-inner {
        height: 20em; /* Match this to the image height */
    }
    @media (max-width: 768px) {
        .carousel-item > img {
            height: 15em; /* Reduced height for smaller screens */
        }
        #carouselExampleControls .carousel-inner {
            height: 15em;
        }
    }
    .btn {
        color: #fff;
        margin-top: 20px;
        background-color: #f46000;
    }
    .btn:focus, .btn:hover {
        outline: none;
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }
</style>

<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleControls" class="carousel slide bg-dark" data-bs-ride="carousel">
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
                        <div class="carousel-item <?php echo $_i == 1 ? 'active' : '' ?>">
                            <img src="<?php echo validate_image($upload_path . '/' . $img) ?>" class="d-block w-100" alt="<?php echo $img ?>">
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-10 col-md-11 col-sm-11">
                <div class="card card-outline rounded-0">
                    <div class="card-body">
                        <div class="container-fluid">
                            <center>
                                <hr class="bg-navy opacity-100" style="width:8em;height:3px;">
                            </center>
                            <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
                            <div class="text-center mt-3">
                                <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
