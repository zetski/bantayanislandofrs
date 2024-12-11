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
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .certificate:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .certificate h2, .certificate p {
            color: #333; /* Gray or black color for text */
        }

        .certificate:hover h2, .certificate:hover p {
            color: #333; /* Maintain the same text color on hover */
        }
        
        .certificate img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            border-radius: 5px;
        }

        .certificate h2,
        .certificate p {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap; /* Prevent wrapping for uniform height */
        }

        /* Modal styles */
        .modal {
            display: none; /* Ensure modal is hidden by default */
            position: fixed; /* Ensure modal stays fixed */
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dim the background */
            overflow-y: auto; /* Allow scrolling */
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            margin: 40px auto; /* Add margin for spacing */
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: relative;
            text-align: left;
            overflow-y: auto; /* Scrollable content */
            max-height: 80vh; /* Ensure it doesn't exceed screen height */
        }

        .modal-content img {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            display: block;
            margin: 10px auto; /* Center the image */
        }

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

        ol {
            padding-left: 20px;
            margin-top: 20px;
            color: #000;
        }
        @media (max-width: 768px) {
            .certificate {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .certificate img {
                width: 100%;
                height: auto;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<div class="header">
        <button class="back-button" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h2>Safety Tips</h2>
    </div>

    <div class="content">
        <?php
        // Array of certificates with content for the modal
        $certificates = [
            [
                'title' => 'BEFORE',
                'description' => 'What to do BEFORE a fire?',
                'details' => ' 
                <img src="img/before_cover.png" class="image">
                <p>Ano ang mga dapat gawin BAGO may mangyaring sunog?</p>
                <ol>
                  <li>Ensure that there are at least two ways of escaping the building.</li>
                  <li>Keep first aid boxes and emergency kits handy.</li>
                  <li>Keep heaters at least Three (3) feet from anything that may burn.</li>
                  <li>Keep matches, lighters, or any other tools that may cause fire away from the reach of children.</li>
                  <li>Do not use damaged extension wires or burnt switches.</li>
                  <li>Do not block exits with junk or storage items.</li>
                  <li>If an electric appliance smokes or has an unusual smell, unplug it.</li>
                  <li>If possible, install smoke detectors in the house.</li>
                </ol>',
                'image' => 'img/before.png' // Image for this certificate
            ],
            [
                'title' => 'DURING',
                'description' => 'What to do DURING fire?',
                'details' => ' 
                <img src="img/during_cover.jpg" alt="After description" class="image">
                <p>Ano ang mga dapat gawin HABANG may mangyaring sunog?</p>
                <ol>
                  <li>During a fire, time is critical. If you are able to respond to a fire in the <b>FIRST THREE MINUTES</b>, you may be able to control it.</li>
                  <li>Try to stop any one of the elements that cause fire:<b> HEAT OXYGEN, or FUEL </b>.</li>
                  <li>Use a Fire Extinguisher at once. Learn the <b>P.A.S.S.</b> rule to use it.</li>
                  <li>If you are in a room, <b>STAY LOW and CRAWL OUT</b> the nearest exit. Never try to escape through a burning door or touch hot handles.
                  <br>NEVER use an elevator if you are on the upper storey.</br>
                  <br>NEVER use the bathroom as a refuge. You will only get trapped inside.</br></li>
                  <li>If your clothes are on fire, STOP, DROP, and ROLL until the fire is out. Shout for help but do not run, running makes the fire burn faster.
                  <br>Cover the person who is on fire with a blanket, carpet, or any handy thick material.</br></li>
                  <li>CALL the Fire Department as soon as possible.</li>
                </ol>',
                'image' => 'img/during.jpg' // Image for this certificate
            ],
            [
                'title' => 'AFTER',
                'description' => 'What to do AFTER fire?',
                'details' => '
                <img src="img/after_cover.jpg" alt="After description" class="image">
                <p>Ano ang mga dapat gawin MATAPOS may mangyaring sunog?</p>
                <ol>
                  <li>If someone gets burned, immediately palce the wound under cool water for 10 to 15 minutes. If the wound blisters, see a doctor immediately.</li>
                  <li>If someone inhaled smoke or fumes, immediately seek medical attention.</li>
                  <li>Remove any clothing or jewelry near the burnt area of skin. However, do not try to remove anything that is stuck to the burnt skin because this could cause more damage.</li>
                  <li>Cover burnt area with sterilized bandage.</li>
                  <li>Do not pick the blisters from the burn.</li>
                  <li>Honey or Aloe Vera is good for instant relief for minor burns and scalds.</li>
                  </ol>',
                'image' => 'img/after.png' // Image for this certificate
            ],
            [
                'title' => 'FIRE EXTINGUISHER',
                'description' => 'How to use a FIRE EXTINGUISHER?',
                'details' => '
                <img src="img/pass.png" alt="After description" class="image">
                <p>Paano gamitin ang FIRE EXTINGUISHER?</p>
                <ol>
               <br><b>PULL</b> THE PIN - Pull the pin that locks the operation lever with the handle of the Fire Extinguisher.
               <br><b>AIM</b> THE NOZZLE - Hitting the top of the flame with the fire at its base.
               <br><b>SQUEEZE</b> THE LEVER - In a controlled manner, squeeze the lever to release the agent.
               <br><b>SWEEP</b> SIDE TO SIDE - Sweep the nozzle from side to side until the fire is put out. Keep aiming at the base while you do so. Most extinguishers will give you about 10-20 seconds of discharge time.
                </ol>',
                'image' => 'img/extinguisher.png' // Image for this certificate
            ],
            [
                'title' => 'SUMMER FIRE SAFETY TIPS',
                'description' => 'Fire Safety Tips for the Hot Summer Season',
                'details' => '
                <img src="img/summer_cover.png" alt="After description" class="image">
                <p>Here are some key summer time for fire safety tips to consider and embrace</p>
                <ol>
                <li><b>REMOVE CLUTTER AND UNNECESSARY STORAGE IN YOUR HOME</b>
                <br>Clutter and excessive storage can be added fuel to an unwanted fire and can impede escape from a home fire.</br></li>
                <li><b>CLEAR A FIRE-SAFE ZONE AROUND YOUR HOME</b>
                <br>Clear all dry vegetation, mulch, and trash from around your home exterior.</br></li>
                <li><b>GASOLINE AND OTHER FLAMMABLE LIQUIDS</b>
                <br>Store gasoline and other flammables in approved containers in cool, dark environments out of your home or basement.<br></li>
                <li><b>BARBEQUE GRILL SAFETY</b>
                <br>Keep all barbeque grills at a safe operating distance from your home or other structures.</br></li>
                <li><b>RESIDENTIAL RECREATIONAL FIRE</b>
                <br>When using a commercial chiminea, fire pit or outdoor fireplace unit, always read and observe all manufacturer use, care and safety specifications.</br></li>
                <li><b>HAVE A HOME FIRE ESCAPE PLAN AND PRACTICE IT WITH FAMILY MEMBERS</b>
                <br>During this challenging time with increased numbers of people staying at home - and truthfully all-year-round-families should develop, review and practice their plan regarding what to do if a fire occurs in their home.</br></li>
                </ol>',
                'image' => 'img/summer.jpg' // Image for this certificate
            ],
            [
                'title' => 'SMOKE INHALATION',
                'description' => 'What to do if you Inhale Smoke?',
                'details' => '
                <img src="img/smoke_cover.jpg" alt="After description" class="image">
                <p>Ano ang mga dapat gawin kapag na ka langhap nang usok?</p>
                <ol>
                  <li>Get the person safety and into fresh air if it is safe to do so. Otherwise, filter the smoke with a P2 mask. </li>
                  <li>If they are showing signs of smoke inhalation (e.g., dizziness, grey/black saliva, chest pain) call emergency.</li>
                  <li>If the person is conscious, sit them down or lay them on their side.</li>
                  <li>If the person is alert, ask them whether they have any medical conditions.</li>
                  <li>If the person is not breathing, perform CPR.</li>
                  <li>Ensure the person seeks medical attention to be assessed for more serious health implications.</li>
                  </ol>',
                'image' => 'img/smoke.png' // Image for this certificate
            ],
            [
                'title' => 'CLOTHES CATCH FIRE',
                'description' => 'What to do if your Clothes Catch Fire',
                'details' => '
                <img src="img/stop-drop-and-roll.jpg" alt="After description" class="image">
                <p>Ano ang mga dapat gawin kapag nagkaroon nang apoy ang iyong damit?</p>
                <ol>
                  <li><b>STOP</b>
                  <br>Stop where you are.</br></li>
                  <li><b>DROP</b>
                  <br>Drop to the ground.</br></li>
                  <li><b>ROLL</b>
                  <br>Cover your face with hands, and roll over and over until the fire is out.</br></li>
                  </ol>',
                'image' => 'img/clothes_fire.png' // Image for this certificate
            ],
            [
                'title' => 'BURNS',
                'description' => 'first Aid for Minor Burns',
                'details' => '
                <img src="img/burn-arm-first-aid.jpg" alt="After description" class="image">
                <p>First Aid treatment for Minor-degree and small second-degree burns</p>
                <ol>
                <li>Place the the burn area under running cool water for at least 5 minutes reduce swelling.</li>
                <li>Apply on atiseptic spray, antibiotic ointment, or aloe vera cream to soothe the area</li>
                <li>Loosely wrap a gauze bandage around the burn if risk of damage or contamination is inevitable</li>
                <li>Never put butter on a burn or pop any blisters that form. You could damage the skin and cause an infection.</li>
                <li>Seek immediate medical attention or go to the nearest hospital if necessary.</li>
                ',
                'image' => 'img/burn.png' // Image for this certificate
            ],
            [
                'title' => 'CUTS AND SCRAPES',
                'description' => 'First Aid for Cuts and Scrapes',
                'details' => '
                <img src="img/cut_scrapes_cover.png" alt="After description" class="image">
                <p>First Aid treatment keep Cuts clean and prevent infections and scars</p>
                <ol>
                <li>Wash your hands.
                <br>First, wash up with soap and water so you do not get bacteria into the cut and cause an infection. If you are on the go, use hand sanitizer.</li>
                <li>Stop the bleeding.
                <br>Put pressure on the cut with a gauze pad or clean cloth. Keep the pressure on for a few minutes.</li>
                <li>Clean the wound.
                <br>Once you have stopped the bleeding, rinse the cut under cool running water or use a saline wound wash.
                <br>Clean the are around the wound with soap and a wet wash cloth.
                <br>Do not get soap in the cut, because it can irritate the skin and do not use hydrogen peroxide or iodine, which is could irritate the cut.</br></li>
                <li>Remove any dirt or debris.
                <br>Use a pair of tweezers cleaned with alcohol to gently pick out any dirt, gravel, or other material in the cut.</br></li>
                <li>Seek immediate medical treatment attention or go to the nearest hospital if necessary.</li>
                ',
                'image' => 'img/cuts_scrapes.png' // Image for this certificate
            ],        
            // Additional certificates...
        ];

        // Loop through the array and display the certificates
        foreach ($certificates as $index => $certificate) {
            echo '<div class="certificate" id="certificate-' . $index . '">';
            echo '<img src="' . $certificate['image'] . '" alt="' . $certificate['title'] . ' Icon">'; // Dynamic image
            echo '<div>';
            echo '<h2>' . $certificate['title'] . '</h2>';
            echo '<p>' . $certificate['description'] . '</p>';
            echo '</div>';
            echo '</div>';

            // Modal structure for each certificate
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
        const maxDescriptionLength = 120; // Adjust as needed

        // Ensure consistent description length
        document.querySelectorAll('.certificate p').forEach((description) => {
            if (description.textContent.length > maxDescriptionLength) {
                description.textContent = description.textContent.slice(0, maxDescriptionLength) + '...';
            }
        });

        <?php foreach ($certificates as $index => $certificate): ?>
            var modal<?php echo $index; ?> = document.getElementById("modal-<?php echo $index; ?>");
            var certificate<?php echo $index; ?> = document.getElementById("certificate-<?php echo $index; ?>");
            var close<?php echo $index; ?> = document.getElementById("close-<?php echo $index; ?>");

            // Show modal on certificate click
            certificate<?php echo $index; ?>.onclick = function() {
                modal<?php echo $index; ?>.style.display = "flex";
            }

            // Close modal on 'x' button click
            close<?php echo $index; ?>.onclick = function() {
                modal<?php echo $index; ?>.style.display = "none";
            }

            // Close modal on outside click
            window.onclick = function(event) {
                if (event.target == modal<?php echo $index; ?>) {
                    modal<?php echo $index; ?>.style.display = "none";
                }
            }
        <?php endforeach; ?>
    });
    </script>

</body>
</html>
