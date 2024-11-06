<style>
    .contact-icon {
        font-size: 1.5em;
        color: #dc3545; /* Bootstrap danger color */
        margin-right: 10px;
    }
    .contact-details {
        margin-top: 20px;
    }
    .contact-details dt {
        display: flex;
        align-items: center;
    }
    .contact-details dd {
        margin-left: 2em;
    }
    .content {
        margin-top: 100px;
    }
</style>

<div class="container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <div class="card rounded-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center"><b>Contact Us</b></h3>
                        <center><hr style="height:2px;width:5em;opacity:1" class="bg-danger"></center>
                        <dl class="contact-details">
                            <dt class="text-muted">
                                <i class="fas fa-envelope contact-icon"></i> Email
                            </dt>
                            <dd><?= $_settings->info('email') ?></dd>
                            <dt class="text-muted">
                                <i class="fas fa-phone contact-icon"></i> Telephone #
                            </dt>
                            <dd><?= $_settings->info('phone') ?></dd>
                            <dt class="text-muted">
                                <i class="fas fa-mobile-alt contact-icon"></i> Mobile #
                            </dt>
                            <dd><?= $_settings->info('mobile') ?></dd>
                            <!-- New Facebook field with icon -->
                            <dt class="text-muted">
                                <i class="fab fa-facebook-square contact-icon"></i> Facebook
                            </dt>
                            <dd><?= $_settings->info('facebook') ?></dd>
                            <dt class="text-muted">
                                <i class="fas fa-map-marker-alt contact-icon"></i> Address
                            </dt>
                            <dd><?= $_settings->info('address') ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include FontAwesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
