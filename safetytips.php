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
        html, body {
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }
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
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
        }
        .back-button {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #ff4500;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .back-button i {
            pointer-events: none;
        }
        .back-button:hover {
            background-color: #ff6347;
        }
        h2 {
            margin: 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            color: white;
        }
        .certificate {
            background-color: white;
            border-radius: 8px;
            margin: 15px auto;
            padding: 15px;
            width: 90%;
            max-width: 600px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .certificate img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            border-radius: 5px;
        }
        .certificate:hover {
            transform: scale(1.02);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: left;
            position: relative;
            overflow-y: auto;
            max-height: 80vh;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="header">
    <button class="back-button" onclick="history.back()">
        <i class="fas fa-arrow-left"></i>
    </button>
    <h2>SAFETY TIPS</h2>
</div>
<div class="content">
    <?php
    foreach ($certificates as $index => $certificate) {
        echo '<div class="certificate" onclick="openModal(' . $index . ')">';
        echo '<img src="' . $certificate['image'] . '" alt="Certificate">';
        echo '<div>';
        echo '<h2>' . $certificate['title'] . '</h2>';
        echo '<p>' . $certificate['description'] . '</p>';
        echo '</div></div>';
    }
    ?>
</div>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modal-details"></div>
    </div>
</div>
<script>
    const certificates = <?php echo json_encode($certificates); ?>;
    const modal = document.getElementById('modal');
    const modalDetails = document.getElementById('modal-details');

    function openModal(index) {
        modalDetails.innerHTML = certificates[index].details;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
</body>
</html>
