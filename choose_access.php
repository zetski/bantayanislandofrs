<?php
// Start a session with secure configuration
ini_set('session.cookie_secure', '1'); // Send cookies over HTTPS only
ini_set('session.cookie_httponly', '1'); // Prevent JavaScript access to cookies
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
session_set_cookie_params([
    'lifetime' => 3600, // 1-hour session duration
    'path' => '/',
    'domain' => '', // Specify domain if needed
    'secure' => true, // Ensure cookie is sent over HTTPS
    'httponly' => true, // Prevent access via JavaScript
    'samesite' => 'Strict', // CSRF protection
]);

session_start();

// Handle session expiration
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    // Session expired after 1 hour
    session_unset(); // Clear session data
    session_destroy(); // Destroy the session
    header("Location: ./index"); // Redirect to the entry point
    exit;
}
$_SESSION['last_activity'] = time(); // Update last activity time

// Role-based redirection
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'guest') {
        header("Location: ./?p=report");
        exit;
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: ./admin");
        exit;
    }
}

// Block certain User-Agents
$disallowedUserAgents = [
    "BurpSuite", 
    "Cyberfox", 
    "OWASP ZAP", 
    "PostmanRuntime"
];

if (preg_match("/(" . implode("|", $disallowedUserAgents) . ")/i", $_SERVER['HTTP_USER_AGENT'])) {
    http_response_code(403);
    exit("Unauthorized access");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/r7logo.png" type="image/png">
    <title>Online Fire Reporting System</title>
    <style>
        /* Basic styles for the gateway page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            /* Background image settings */
            background-image: url('../img/bgfront.jpg'); 
            background-size: cover; 
            background-position: center center; 
            background-attachment: fixed; 
            background-repeat: no-repeat; 
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        .btn {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .guest-btn {
            background-color: #007bff;
        }
        .admin-btn {
            background-color: #ff4600;
        }
    </style>
    <script type="text/javascript">
        // Disable right-click with an alert
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            alert("Right-click is disabled on this page.");
        });

        // Disable F12 key and Inspect Element keyboard shortcuts with alerts
        document.onkeydown = function(e) {
            // F12
            if (e.key === "F12") {
                alert("F12 (DevTools) is disabled.");
                e.preventDefault(); // Prevent default action
                return false;
            }

            // Ctrl + Shift + I (Inspect)
            if (e.ctrlKey && e.shiftKey && e.key === "I") {
                alert("Inspect Element is disabled.");
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + J (Console)
            if (e.ctrlKey && e.shiftKey && e.key === "J") {
                alert("Console is disabled.");
                e.preventDefault();
                return false;
            }

            // Ctrl + U or Ctrl + u (View Source)
            if (e.ctrlKey && (e.key === "U" || e.key === "u")) {
                alert("Viewing page source is disabled.");
                e.preventDefault();
                return false;
            }
        };

        (function() {
            const detectDevToolsAdvanced = () => {
                // Detect if the console is open by triggering a breakpoint
                const start = new Date();
                debugger; // This will trigger when dev tools are open
                const end = new Date();
                if (end - start > 100) {
                    document.body.innerHTML = "<h1>Unauthorized Access</h1><p>Developer tools are not allowed on this page.</p>";
                    document.body.style.textAlign = "center";
                    document.body.style.paddingTop = "20%";
                    document.body.style.backgroundColor = "#fff";
                    document.body.style.color = "#000";
                }
            };

            setInterval(detectDevToolsAdvanced, 500); // Continuously monitor
        })();

        const blockedAgents = ["Cyberfox", "Kali"];
        if (blockedAgents.some(agent => navigator.userAgent.includes(agent))) {
            document.body.innerHTML = "<h1>Access Denied</h1><p>Your browser is not supported.</p>";
        }

        if (window.__proto__.toString() !== "[object Window]") {
            alert("Unauthorized modification detected.");
            window.location.href = "https://www.bible-knowledge.com/wp-content/uploads/battle-verses-against-demonic-attacks.jpg";
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Bantayan BFP</h2>
        <button class="btn guest-btn" onclick="window.location.href='./set_guest'">Continue as Guest</button>
        <button class="btn admin-btn" onclick="window.location.href='./verifyotp/send_otp'">Login as Admin</button>
    </div>
</body>
</html>
