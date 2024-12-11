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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/r7logo.png" type="image/png">
    <title>Online Fire Reporting System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #f7f7f7, #ffffff);
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #ff4500;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            font-size: 24px;
            font-weight: bold;
        }

        .back-button {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: 24px;
        }

        .content {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .certificate-list {
            flex: 1;
            min-width: 300px;
        }

        .certificate {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            padding: 20px;
            text-align: left;
            cursor: pointer;
        }

        .certificate h2 {
            font-size: 20px;
            font-weight: bold;
            color: #ff4500;
            margin: 0;
        }

        .certificate .details {
            font-size: 16px;
            color: #666;
            display: none;
            margin-top: 10px;
        }

        .certificate.active .details {
            display: block;
        }

        .video-container {
            padding-top: 10px;
            flex: 1;
            min-width: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-container video {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        @media screen and (max-width: 768px) {
            .content {
                flex-direction: column;
            }

            .video-container {
                order: -1;
                margin-bottom: 20px;
            }
        }
    </style>
    <script>
        function toggleDetails(event) {
            const certificate = event.currentTarget;
            certificate.classList.toggle('active');
        }
    </script>
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        Citizen Charter
    </div>

    <div class="content">
        <div class="certificate-list">
            <?php
            $certificates = [
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'New Business Permit WITH Valid FSIC During Occupancy Permit Stage',
                    'details' => '
                    <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(New Business Permit WITH Valid FSIC During Occupancy Permit Stage)</br></p>
                    <ol>
                      <li>Apply for FSIC using the Unified Form with complete documentary requirements.</li>
                      <li>Wait for the release of Order of Payment (OP).</li>
                      <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                      <li>Receive Claim Stub. (FSIC shall be issued within the day)</li>
                      <li>Owner/Authorized representative present Claim Stub to claim FSIC.</li>
                    </ol>
                    <p><b>REQUIREMENTS:</b></p>
                    <ol>
                      <li>Certified True Copy of valid Occupancy Permit.</li>
                      <li>Photocopy of FSIC for Occupancy.</li>
                      <li>Assessment of Business Permit fee/Tax Assessment Bill from BPLO.</li>
                      <li>Copy of Fire Insurance Policy (if any).</li>
                    </ol>
                    <p>1 DAY MAXIMUM</p>
                    <p>Source: New BFP Citizen\'s Charter 2017</p>'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'New Business Permit WITHOUT Valid FSIC During Occupancy Permit Stage',
                    'details' => '
                    <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(New Business Permit WITHOUT Valid FSIC During Occupancy Permit Stage)</br></p>
                    <ol>
                      <li>Apply for FSIC using the Unified Form with complete documentary requirements.</li>
                      <li>Wait for the release of Order of Payment (OP).</li>
                      <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                      <li>Receive Claim Stub. FSIC will be issued within a maximum period of 3 days from application if no violation is found during inspection.</li>
                      <li>Owner/Authorized representative present Claim Stub to claim FSIC.</li>
                    </ol>
                    <p><b>REQUIREMENTS:</b></p>
                    <ol>
                      <li>Assessment of Business Permit Fee.</li>
                      <li>Tax Assessment Bill from BPLO.</li>
                      <li>Endorsement from BO/Certificate of Completion.</li>
                      <li>Certified True Copy of Assessment FEE.</li>
                    </ol>
                    <p>3 DAYS MAXIMUM</p>
                    <p>Source: New BFP Citizen\'s Charter 2017</p>'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'Renewal of FSIC for Business Permit WITHOUT Valid FSIC or expired FSIC/with Existing Violations of the Fire Code/included in the Negative list',
                    'details' => '
                    <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(Renewal of FSIC for Business Permit WITHOUT Valid FSIC or expired FSIC/with Existing Violations of the Fire Code/included in the Negative list)</br></p>
                    <ol>
                      <li>Apply for FSIC using the Unified Form with complete documentary requirements.</li>
                      <li>Wait for the release of Order of Payment (OP).</li>
                      <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                      <li>Receive Claim Stub. FSIC will be issued within a maximum period of 3 days from application if no violation is found during inspection.</li>
                      <li>Owner/Authorized representative present Claim Stub to claim FSIC.</li>
                    </ol>
                    <p><b>REQUIREMENTS:</b></p>
                    <ol>
                      <li>Photocopy of previous FSIC (if any).</li>
                      <li>Assessment of Business Permit Fee/Tax  or Assessment Bill from BPLO.</li>
                      <li>Copy of Fire Insurance Policy.</li>
                    </ol>
                    <p>2 DAYS MAXIMUM</p>
                    <p>Source: New BFP Citizen\'s Charter 2017</p>'
            ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSIC for Renewal of Business Permit',
                    'details' => '
                  <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(FSIC for Renewal of Business Permit)</br></p>
                  <ol>
                    <li>Apply for FSIC using the Unified Form with complete documentary requirements.</li>
                    <li>Wait for the release of Order of Payment (OP).</li>
                    <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                    <li>Receive Claim Stub.</li>
                    <li>Owner/Authorized representative present Claim Stub to claim FSIC. (A new FSIC will be issued if there is no violation during inspection).</li>
                  </ol>
                  <p><b>REQUIREMENTS:</b></p>
                  <ol>
                    <li>Photocopy of previous FSIC (Issued in the immediately preceding year).</li>
                    <li>Assessment of Business Permit Fee/Tax  or Assessment Bill from BPLO.</li>
                    <li>Copy of Fire Insurance Policy (if any).</li>
                  </ol>
                  <p>1 DAY MAXIMUM</p>
                  <p>Source: New BFP Citizen\'s Charter 2017</p>'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSIC for Occupancy Permit',
                    'details' => '
                <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(FSIC for Occupancy Permit)</br></p>
                <ol>
                  <li>Apply for FSIC using the Unified Form with complete documentary requirements.</li>
                  <li>Wait for the release of Order of Payment (OP).</li>
                  <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                  <li>Receive Claim Stub (<b>Note:</b> FSIC will be issued within the maximum period pf three (3) days from application if no violation of the Fire Code and its IRR has been noted during inspection).</li>
                  <li>Owner/Authorized representative present Claim Stub to claim FSIC.</li>
                </ol>
                <p><b>REQUIREMENTS:</b></p>
                <ol>
                  <li>Endorsement from BO/Certificate of Completion</li>
                  <li>Certified True Copy of Assessment Fee for securing Occupancy Permit from BO.</li>
                </ol>
                <p>3 DAYS MAXIMUM</p>
                <p>Source: New BFP Citizen\'s Charter 2017</p>'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSEC for Building Permit',
                    'details' => '
              <p><b>FIRE SAFETY INSPECTION CERTIFICATE</b><br>(FSIC for Building Permit)</br></p>
              <ol>
                <li>Apply for FSEC using the Unified Form with complete documentary requirements.</li>
                <li>Wait for the release of Order of Payment (OP).</li>
                <li>Pay the assessed amount and submit copy of receipt of payment to CRO.</li>
                <li>Receive Claim Stub (<b>Note:</b> FSIC will be issued within the maximum period pf three (3) days from application if no violation of the Fire Code and its IRR).</li>
                <li>Owner/Authorized representative present Claim Stub to claim FSEC.</li>
              </ol>
              <p><b>REQUIREMENTS:</b></p>
              <ol>
                <li>Three (3) complete sets of Building Plans and specifications. </li>
                <li>Estimated cost of the building to be constructed/renovated/modified as reflected in the Bill of Materials including labor cost signed by the Designer/Contractor.</li>
              </ol>
              <p>3 DAYS MAXIMUM</p>
              <p>Source: New BFP Citizen\'s Charter 2017</p>'
                ],
            ];

            foreach ($certificates as $certificate) {
                echo '<div class="certificate" onclick="toggleDetails(event)">';
                echo '<h2>' . $certificate['title'] . '</h2>';
                echo '<div class="details">' . ($certificate['details'] ?? $certificate['description']) . '</div>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="video-container">
            <video controls>
            <source src="img/vid.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>
