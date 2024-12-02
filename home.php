<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Design</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .text-section {
            flex: 1;
            padding: 20px;
        }
        .text-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .text-section p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .text-section .btn {
            background-color: #f46000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
        }
        .text-section .btn:hover {
            background-color: #d94d00;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .image-carousel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ddd;
            border-radius: 8px;
            height: 300px;
            max-width: 500px;
        }
        .image-carousel img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-section">
            <h1>Welcome</h1>
            <p>
                Fire safety is the set of practices intended to reduce the destruction caused by fire. Fire safety measures include those that are intended to prevent ignition of an uncontrolled fire, and those that are used to limit development and effects of a fire after it starts.
            </p>
            <button class="btn" onclick="location.href='./upcoming_events.html'">Upcoming Events</button>
        </div>
        <div class="image-carousel">
            <img src="static/banner-placeholder.png" alt="Image Carousel">
        </div>
    </div>
</body>
</html>
