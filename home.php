<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        line-height: 1.6;
        background: url('img/r7logo.png') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
    }

    .section-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: calc(100vh - 56px); /* Adjust height to account for navbar */
    width: 100%; /* Take full width of the viewport */
    padding: 2rem; /* Uniform padding */
    text-align: center;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
    box-sizing: border-box; /* Include padding in the total width and height */
}

@media (min-width: 992px) { /* For navbar-expand-lg breakpoint */
    .section-content {
        padding: 2rem 15%; /* Add side padding for larger screens */
    }
}

    .btn {
        color: #fff;
        margin-top: 20px;
        padding: 12px 30px;
        background-color: #f46000;
        border: none;
        border-radius: 50px; /* Fully rounded corners */
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        background-color: #d94c00;
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    @media (min-width: 768px) {
        .btn {
            font-size: 1.4rem;
        }
    }

    @media (min-width: 1024px) {
        .btn {
            font-size: 1.6rem;
        }
    }
</style>

<section class="section-content">
    <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
    <div>
        <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
    </div>
</section>
