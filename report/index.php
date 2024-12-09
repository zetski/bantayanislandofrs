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

    // Check for duplicate reports
    $stmt = $conn->prepare("SELECT COUNT(*) FROM request_list WHERE municipality = ? AND barangay = ? AND sitio_street = ?");
    $stmt->bind_param("sss", $municipality, $barangay, $sitio_street);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Duplicate report found
        echo "<script>alert('A report for this location has already been submitted. Please check your details or contact the administrator.');</script>";
    } else {
        // Proceed with file upload and data insertion
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = mime_content_type($fileTmpPath);
            $allowedMimeTypes = ['image/jpeg'];

            if (!in_array($fileType, $allowedMimeTypes)) {
                die('Invalid file type. Only JPEG/JPG images are allowed.');
            }

            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, ['jpg', 'jpeg'])) {
                die('Invalid file extension. Only .jpg and .jpeg are allowed.');
            }

            $uploadFileDir = './uploads/';
            $destPath = $uploadFileDir . $fileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Insert sanitized data into the database
                $stmt = $conn->prepare("INSERT INTO request_list (lastname, firstname, middlename, contact, subject, message, municipality, barangay, sitio_street, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssss", $lastname, $firstname, $middlename, $contact, $subject, $message, $municipality, $barangay, $sitio_street, $destPath);

                if ($stmt->execute()) {
                    echo "<script>alert('Your report has been successfully submitted.');</script>";
                } else {
                    echo "<script>alert('Failed to submit your report. Please try again.');</script>";
                }
                $stmt->close();
            } else {
                die('File upload failed.');
            }
        } else {
            die('No file uploaded or upload error occurred.');
        }
    }

    $conn->close();
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
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms-checkbox" required>
                                    <label class="form-check-label" for="terms-checkbox">I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a></label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer py-1 text-center">
                        <button id="submit-button" class="btn btn-flat btn-sm btn-primary bg-gradient-primary" form="request-form" disabled>
                            <i class="fa fa-paper-plane"></i> Submit
                        </button>
                        <button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" onclick="window.location.href='./';">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal for Terms and Conditions -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Terms and Conditions for Bureau Fire Protection Incident Reporting System</h5>
                <p>Please read and agree to the following terms and conditions before submitting your incident report.</p>
                <p><strong>1. Acceptance of Terms</strong></p>
                <p>By submitting your incident report, you agree to these terms and conditions...</p>

                <p><strong>2. Registration and Use of Service</strong></p>
                <p>2.1 To use our online fire reporting system, you must provide accurate information such as your name, contact number, address, and image.  
                2.2 The information you provide will be used to process your report and address any needs related to the fire incident you report.  
                2.3 You are responsible for ensuring that all information provided is correct, complete, and accurate.  
                2.4 You may not provide false information or make fraudulent reports.</p>

                <p><strong>3. Fire Incident Reporting</strong></p>
                <p>3.1 The purpose of our system is to assist individuals in reporting fire incidents. You should use the service only for this purpose and not for any illegal activities.  
                3.2 We are not responsible for any false reports or inaccurate information provided by users.  
                3.3 Reports submitted through the system will be part of our database and may be used by authorities for appropriate action regarding the fire incident.</p>

                <p><strong>4. Privacy and Protection of Personal Information</strong></p>
                <p>4.1 Your personal information, such as your name, address, and contact details, will be kept confidential and will not be sold or shared with third parties, unless required by law.  
                4.2 Our system complies with data protection and privacy policies to ensure the security of your information.</p>

                <p><strong>5. User Responsibilities</strong></p>
                <p>5.1 You are responsible for any content you submit or upload to our platform.  
                5.2 You may not upload any content containing viruses, malware, or any harmful code that could damage our service.  
                5.3 You may not use our system to engage in illegal activities or to cause harm.</p>

                <p><strong>6. Contacting the Admin</strong></p>
                <p>6.1 If you have any questions, complaints, or need further information, you may contact the admin via email at <a href="mailto:">bantayanbfp@gmail.com</a>.  
                6.2 The admin will respond within a reasonable time based on the issues or inquiries submitted.</p>

                <p><strong>7. Changes to Terms and Conditions</strong></p>
                <p>7.1 We reserve the right to modify or update these Terms and Conditions at any time. We will notify you of any changes via email or notices posted on our website or app.  
                7.2 Your continued use of our service after any changes to these Terms will signify your acceptance of the updated Terms and Conditions.</p>

                <p><strong>8. Termination of Service</strong></p>
                <p>8.1 We reserve the right to suspend or terminate your access to our system at any time, at our sole discretion, if we suspect any violation of these Terms and Conditions.  
                8.2 Termination of access will not affect any obligations that you have incurred prior to termination.</p>

                <p><strong>9. Disclaimer of Liability</strong></p>
                <p>9.1 While we make every effort to ensure the accuracy and functionality of our system, we are not liable for any errors, delays, or technical issues that may occur in the use of our website and mobile app.  
                9.2 We are not liable for any damage, loss, or costs arising from the improper use of our service.</p>

                <p><strong>10. Ownership of Content</strong></p>
                <p>10.1 All materials, designs, text, software, and other content found on the website and mobile app are owned by <b>BANTAYAN ISLAND OFRS</b> and are protected by copyright and intellectual property laws.  
                10.2 You may not copy, reproduce, modify, or distribute any of these materials without our permission.</p>

                <p><strong>11. Governing Law</strong></p>
                <p>11.1 These Terms and Conditions are governed by the laws of <b>BANTAYAN ISLAND</b>.  
                11.2 Any disputes arising from these Terms and Conditions will be resolved in the courts having jurisdiction in the relevant country or state.</p>

                <p><strong>12. Acknowledgment</strong></p>
                <p>By using our website and mobile app, you acknowledge and agree to the Terms and Conditions outlined above. If you have any questions or concerns, please do not hesitate to contact us.</p>
            </div>
        </div>
    </div>
</div>



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
     // Get the checkbox and submit button elements
     const termsCheckbox = document.getElementById('terms-checkbox');
    const submitButton = document.getElementById('submit-button');

    // Add event listener to the checkbox
    termsCheckbox.addEventListener('change', function () {
        // Enable the button if the checkbox is checked, otherwise disable it
        submitButton.disabled = !termsCheckbox.checked;
    });
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

            document.getElementById('image').addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const allowedExtensions = ['jpg', 'jpeg'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();

                    if (!allowedExtensions.includes(fileExtension)) {
                        alert('Invalid file type. Please upload a JPEG/JPG image.');
                        this.value = ''; // Clear the input
                    }
                }
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