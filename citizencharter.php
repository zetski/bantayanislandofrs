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
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: auto;
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

        h1 {
            font-size: 36px;
            margin: 0;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .content {
            text-align: center;
            padding: 20px;
            color: #fff;
        }

        .certificate {
            background-color: #fff;
            border-radius: 8px;
            margin: 10px auto;
            padding: 15px;
            width: 90%;
            max-width: 600px;
            display: flex;
            flex-direction: column; /* Ensure elements are stacked */
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            overflow: hidden; /* Hide content that overflows */
            height: 200px; /* Set a fixed height */
        }
        
        .certificate:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .certificate img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px; /* Add spacing between image and text */
            border-radius: 5px;
        }

        .certificate h2,
        .certificate p {
            margin: 0;
            text-align: center;
            word-wrap: break-word; /* Break words to avoid overflow */
        }

        /* Modal styles */
        .modal {
        display: none; /* Ensure modal is hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        max-height: 90%; /* Limit modal height to 90% of the viewport */
        overflow-y: auto; /* Enable vertical scrolling for long content */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    /* Close button styles */
    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }
    .close:hover {
        color: #333;
    }

    /* Prevent body scrolling when modal is open */
    body.modal-open {
        overflow: hidden;
    }
    ol {
            padding-left: 20px;
            text-align: left;
            color: #000;
        }
    </style>
</head>
<body>
<div class="header">
        <button class="back-button" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h3>Citizen Charter</h3>
    </div>

    <div class="content">
        <?php
        // Array of certificates with content for the modal
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
          'title' => 'FIRE SAFETY EVALUATION CERTIFICATE',
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
            // Add more certificates as needed...
        ];

        // Display certificates with modals
        foreach ($certificates as $index => $certificate) {
            echo '<div class="certificate" id="certificate-' . $index . '">';
            echo '<img src="img/firebg.jpg" alt="Fire Icon">';
            echo '<div>';
            echo '<h2>' . $certificate['title'] . '</h2>';
            echo '<p>' . $certificate['description'] . '</p>';
            echo '</div>';
            echo '</div>';

            echo '<div id="modal-' . $index . '" class="modal">';
            echo '<div class="modal-content">';
            echo '<span class="close" id="close-' . $index . '">&times;</span>';
            echo $certificate['details'];
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php foreach ($certificates as $index => $certificate): ?>
                var modal<?php echo $index; ?> = document.getElementById("modal-<?php echo $index; ?>");
                var certificate<?php echo $index; ?> = document.getElementById("certificate-<?php echo $index; ?>");
                var close<?php echo $index; ?> = document.getElementById("close-<?php echo $index; ?>");

                // Show modal on certificate click
                certificate<?php echo $index; ?>.onclick = function() {
                    modal<?php echo $index; ?>.style.display = "flex";
                    document.body.classList.add('modal-open'); // Prevent background scrolling
                }

                // Close modal on 'x' button click
                close<?php echo $index; ?>.onclick = function() {
                    modal<?php echo $index; ?>.style.display = "none";
                    document.body.classList.remove('modal-open'); // Restore background scrolling
                }

                // Close modal on outside click
                window.onclick = function(event) {
                    if (event.target == modal<?php echo $index; ?>) {
                        modal<?php echo $index; ?>.style.display = "none";
                        document.body.classList.remove('modal-open'); // Restore background scrolling
                    }
                }
            <?php endforeach; ?>
        });
    </script>

</body>
</html>
