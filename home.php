<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .section-content {
        padding: 2rem 1rem;
        text-align: center;
        align-items: center;
    }

    .btn {
        color: #fff;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #f46000;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        background-color: #d94c00;
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }


    @media (min-width: 768px) {
        .section-content {
            padding: 4rem 2rem;
        }

        .btn {
            font-size: 1.2rem;
        }
    }

    @media (min-width: 1024px) {
        .btn {
            font-size: 1.5rem;
        }
    }
</style>

<section class="section-content">
    <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
    <div>
        <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
    </div>
</section>
