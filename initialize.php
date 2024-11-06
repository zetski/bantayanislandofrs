<?php
// $dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'dev_oretnom','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');

// LIVE SERVER

// if(!defined('base_url')) define('base_url','https://bantayan-bfp.com/');
// if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
// // if(!defined('dev_data')) define('dev_data',$dev_data);
// if(!defined('DB_SERVER')) define('DB_SERVER',"127.0.0.1:3306");
// if(!defined('DB_USERNAME')) define('DB_USERNAME',"u510162695_ofrs_db");
// if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"1Ofrs_db");
// if(!defined('DB_NAME')) define('DB_NAME',"u510162695_ofrs_db");

// LOCALHOST 

if(!defined('base_url')) define('base_url','http://localhost/ofrs/');
    if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
    // if(!defined('dev_data')) define('dev_data',$dev_data);
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");
    if(!defined('DB_NAME')) define('DB_NAME',"ofrs_db");
    // Establish the connection
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>