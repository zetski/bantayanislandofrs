<?php
// Database connection parameters
// define('DB_SERVER', "localhost");
// define('DB_USERNAME', "root");
// define('DB_PASSWORD', "");
// define('DB_NAME', "sunog");

// // Create connection
// $con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// // Check connection
// if ($con->connect_error) {
//     die("Connection failed: " . $con->connect_error);
// }


// Base URL and application directory constants
define('base_url', 'https://bantayan-bfp.com/');
define('base_app', str_replace('\\', '/', __DIR__) . '/');

// Database connection parameters
define('DB_SERVER', "127.0.0.1"); // or "localhost"
define('DB_PORT', 3306); // Optional, can be used if you want to be explicit
define('DB_USERNAME', "u510162695_ofrs_db");
define('DB_PASSWORD', "1Ofrs_db");
define('DB_NAME', "u510162695_ofrs_db");

// Create a database connection
$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Set the character set to utf8mb4 for better compatibility with various characters
$con->set_charset("utf8mb4");
?>
