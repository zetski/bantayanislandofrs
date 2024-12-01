<?php
// Secure Headers
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Secure Cookie Flags
ini_set('session.cookie_secure', '1'); // Send cookies over HTTPS only
ini_set('session.cookie_httponly', '1'); // Prevent JavaScript access to cookies
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
ini_set('session.use_only_cookies', '1'); // Ensure session only uses cookies

// Session Configuration
session_set_cookie_params([
    'lifetime' => 3600, // 1-hour session duration
    'path' => '/',
    'domain' => '', // Specify domain if needed
    'secure' => true, // Ensure cookie is sent over HTTPS
    'httponly' => true, // Prevent access via JavaScript
    'samesite' => 'Strict', // CSRF protection
]);

session_start();

// Session expiration logic
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    // Session expired after 1 hour
    session_unset(); // Clear session data
    session_destroy(); // Destroy the session
    header("Location: ./index"); // Redirect to index
    exit;
}
$_SESSION['last_activity'] = time(); // Update last activity time

// Sanitize Input Function
function sanitizeInput($data) {
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = trim($data);
    return $data;
}

// Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = sanitizeInput($_POST['lastname']);
    $firstname = sanitizeInput($_POST['firstname']);
    $middlename = sanitizeInput($_POST['middlename']);
    $contact = sanitizeInput($_POST['contact']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);
    $municipality = sanitizeInput($_POST['municipality']);
    $barangay = sanitizeInput($_POST['barangay']);
    $sitio_street = sanitizeInput($_POST['sitio_street']);
    
    // Process the sanitized data (e.g., insert into database)
}
?>

<section class="py-3">
    <div class="container">
        <div class="content py-3 px-3" style="background-color: #FF4600">
            <h2 style="color: #fff">Fire Reporting</h2>
        </div>
        <div class="row justify-content-center mt-n3">
            <div class="col-lg-8 col-md-10 col-sm-12 col-sm-12">
                <div class="card card-outline rounded-0">
                    <div class="card-body">
                        <div class="container-fluid">
                            <?php if($_settings->chk_flashdata('request_sent')): ?>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    html: 'Your report has been sent successfully. Your request code id: <b><?= $_settings->flashdata('request_sent') ?></b>',
                                    showConfirmButton: true,
                                });
                            </script>
                            <?php endif;?>
                            <form action="" id="request-form" enctype="multipart/form-data">
                                <input type="hidden" name="id">
                                
                                <!-- Lastname, Firstname, Middlename -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="lastname" class="control-label">Lastname <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="lastname" id="lastname" required="required">
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="firstname" class="control-label">Firstname <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="firstname" id="firstname" required="required">
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="middlename" class="control-label">Middlename</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="middlename" id="middlename">
                                </div>

                                <!-- Contact -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="contact" class="control-label">Contact # <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="contact" id="contact" required="required" maxlength="11" pattern="\d{11}" title="Please enter 11 digits">
                                </div>

                                <!-- Subject -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="subject" class="control-label">Subject <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="subject" id="subject" required="required">
                                </div>

                                <!-- Message -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="message" class="control-label">Message <small class="text-danger">*</small></label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="message" id="message" required="required"></textarea>
                                </div>

                                <!-- Photo Upload -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="image" class="control-label">Upload Photo (JPEG/JPG only) <small class="text-danger">*</small></label>
                                    <input type="file" class="form-control form-control-sm rounded-0" name="image" id="image" accept=".jpeg, .jpg" required="required">
                                </div>

                                <!-- Municipality -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="municipality" class="control-label">Municipality <small class="text-danger">*</small></label>
                                    <select class="form-control form-control-sm rounded-0" name="municipality" id="municipality" required="required">
                                        <option value="">Select Municipality</option>
                                        <option value="Bantayan">Bantayan</option>
                                        <option value="Santa Fe">Santa Fe</option>
                                        <option value="Madridejos">Madridejos</option>
                                    </select>
                                </div>

                                <!-- Barangay -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="barangay" class="control-label">Barangay <small class="text-danger">*</small></label>
                                    <select class="form-control form-control-sm rounded-0" name="barangay" id="barangay" required="required">
                                        <option value="">Select Barangay</option>
                                    </select>
                                </div>

                                <!-- Purok/Street -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="sitio_street" class="control-label">Purok/Street <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="sitio_street" id="sitio_street" required="required">
                                </div>
                                <!-- Terms and Conditions Checkbox -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label" for="terms">
                                        <input type="checkbox" id="terms" name="terms"> 
                                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>.
                                    </label>
                                    <small class="text-danger d-none" id="terms-error">You must agree to the terms and conditions.</small>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer py-1 text-center">
                        <button class="btn btn-flat btn-sm btn-primary bg-gradient-primary" form="request-form"><i class="fa fa-paper-plane"></i> Submit</button>
                        <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" onclick="window.location.href='./';"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    body {
        padding-top: 10px;
        margin-top: 40px;
    }
    .position-relative {
        position: relative;
    }
</style>

<script>
    // Define fields that need capitalization for the first letter of each word (except message and sitio_street)
    const fields = ['lastname', 'firstname', 'middlename', 'subject'];

    // Capitalize first letter of each word for specific fields
    fields.forEach(field => {
        document.getElementById(field).addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        });
    });

    // No automatic capitalization for the 'message' field, only prevent special characters
    document.getElementById('message').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^a-zA-Z0-9\s,.!?]/g, ''); // Allow letters, numbers, spaces, and basic punctuation
    });

    document.getElementById('lastname').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            });

            document.getElementById('firstname').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            });

            document.getElementById('middlename').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            });

            // Allow letters, spaces, and the forward slash (/) for the 'sitio_street' field
            document.getElementById('sitio_street').addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s\/]/g, '').replace(/\b\w/g, function (char) {
                    return char.toUpperCase();
                });
            });

            document.getElementById('contact').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
            });

    const barangays = {
        "Bantayan": ["Atop-Atop", "Baigad", "Bantigue", "Baod", "Binaobao", "Botigues", "Doong", "Guiwanon", "Hilotongan", "Kabac", "Kabangbang", "Kampinganon", "Kangkaibe", "Lipayran", "Luyongbay-bay", "Mojon", "Oboob", "Patao", "Putian", "Sillon", "Suba", "Sulangan", "Sungko", "Tamiao", "Ticad"],

        "Santa Fe": ["Balidbid", "Hagdan", "Hilantagaan", "Kinatarkan", "Langub", "Maricaban", "Okoy", "Poblacion", "Pooc", "Talisay"],

        "Madridejos": ["Bunakan", "Kangwayan", "Kaongkod", "Kodia", "Maalat", "Malbago", "Mancilang", "Pili", "Poblacion", "San Agustin", "Tabagak", "Talangnan", "Tarong", "Tugas"]
    };

    document.getElementById('municipality').addEventListener('change', function () {
        const municipality = this.value;
        const barangaySelect = document.getElementById('barangay');
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (barangays[municipality]) {
            barangays[municipality].forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay;
                option.textContent = barangay;
                barangaySelect.appendChild(option);
            });
        }
    });
</script>

<script src="report/script.js"></script>