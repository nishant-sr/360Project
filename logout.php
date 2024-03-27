<?php 
    include 'config.php';
    session_start();
    $user = $_SESSION['user'];

    $user == null;
    $_SESSION['user'] = null;
    header("Location: home.php");
    exit;
?>