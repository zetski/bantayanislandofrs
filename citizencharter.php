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
    justify-content: space-between;
    padding: 20px;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
}

.back-button {
    background-color: #ff4500;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.back-button:hover {
    background-color: #ff6347;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

h3 {
    margin: 0;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
}

.content {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

.certificate {
    background-color: #fff;
    border-radius: 8px;
    margin: 15px 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

.certificate:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.certificate img {
    width: 60px;
    height: 60px;
    margin-bottom: 15px;
    border-radius: 50%;
}

h2 {
    margin: 10px 0;
    font-size: 24px;
    color: #333;
    text-align: center;
}

p {
    margin: 5px 0;
    font-size: 16px;
    color: #555;
    text-align: center;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    position: relative;
}

.close {
    color: #aaa;
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover {
    color: #333;
}

/* Responsive Design */
@media (min-width: 768px) {
    .certificate {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
    }

    .certificate img {
        width: 80px;
        height: 80px;
        margin-bottom: 0;
        margin-right: 20px;
    }

    h2 {
        font-size: 28px;
    }

    p {
        font-size: 18px;
    }
}

@media (min-width: 1024px) {
    .header {
        padding: 30px;
    }

    .certificate {
        padding: 25px;
        margin: 20px 0;
    }

    h2 {
        font-size: 32px;
    }

    p {
        font-size: 20px;
    }
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
