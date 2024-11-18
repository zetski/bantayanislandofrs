<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background: url('your-background-image.jpg') no-repeat center center/cover;
        color: #fff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .content {
        text-align: center;
        background: rgba(0, 0, 0, 0.7); /* Semi-transparent background for readability */
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        margin: 0 20px;
    }

    .content hr {
        background-color: #f46000;
        height: 4px;
        border: none;
        margin: 20px auto;
        width: 80px;
    }

    .content p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
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
</style>

<div class="content">
    <center>
        <hr class="bg-navy opacity-100">
    </center>
    <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
    <div>
        <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
    </div>
</div>
