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
            background-color: #fff;
            color: #ff4500;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .content {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }

        .certificate-list {
            flex: 1;
        }

        .certificate {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            text-align: left;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .certificate:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .certificate h2 {
            font-size: 20px;
            font-weight: bold;
            color: #ff4500;
        }

        .certificate p {
            font-size: 16px;
            color: #666;
        }

        .video-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .video-container video {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="history.back()">Back</button>
        Citizen Charter
    </div>

    <div class="content">
        <div class="certificate-list">
            <?php
            $certificates = [
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'New Business Permit WITH Valid FSIC During Occupancy Permit Stage'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'New Business Permit WITHOUT Valid FSIC During Occupancy Permit Stage'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'Renewal of FSIC for Business Permit WITHOUT Valid FSIC or expired FSIC/with Existing Violations of the Fire Code/included in the Negative list'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSIC for Renewal of Business Permit'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSIC for Occupancy Permit'
                ],
                [
                    'title' => 'FIRE SAFETY INSPECTION CERTIFICATE',
                    'description' => 'FSEC for Building Permit'
                ],
            ];

            foreach ($certificates as $certificate) {
                echo '<div class="certificate">';
                echo '<h2>' . $certificate['title'] . '</h2>';
                echo '<p>' . $certificate['description'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="video-container">
            <video controls>
                <source src="video/sample.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>
