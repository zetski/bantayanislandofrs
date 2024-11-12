<?php
session_start();
$_SESSION['role'] = 'guest';
header("Location: home.php");
exit;
?>
