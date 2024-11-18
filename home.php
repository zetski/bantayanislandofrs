<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container-fluid {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
    }

    .container-fluid center hr {
        background-color: #f46000;
        height: 4px;
        border: none;
        margin: 20px auto;
        width: 80px;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: #f46000;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
        background-color: #e95400;
        transform: scale(1.05);
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(244, 96, 0, 0.8);
    }

    .welcome-wrapper {
        text-align: center;
        padding: 40px 20px;
    }

    .welcome-wrapper p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 20px;
    }

    .welcome-wrapper .btn-container {
        margin-top: 20px;
    }
</style>

<div class="container-fluid">
    <div class="welcome-wrapper">
        <center>
            <hr class="bg-navy opacity-100" style="width:8em;height:3px;opacity:1">
        </center>
        <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
        <div class="btn-container">
            <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
        </div>
    </div>
</div>
