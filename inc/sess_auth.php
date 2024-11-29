<?php 
//session cookie httpflag only
ini_set('session.cookie_httponly', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php') && $_settings->userdata('type') == 2){
	redirect('login');
}
if(isset($_SESSION['userdata']) && strpos($link, 'login.php') && $_settings->userdata('type') == 2){
	redirect('index.php');
}
?>