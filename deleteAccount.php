<?php
    include "config.php";
    session_start();
    $uid = $_SESSION['user_id'] ;
    $sql = "DELETE FROM users WHERE user_id = $uid";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if($_SESSION['Admin']==1){
            header("Location: admin.php");
        }
        else {header("Location: home.php");}
    } else {
    echo "Failed: " . mysqli_error($conn);
    }

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page as needed
header("Location: login.php"); // Redirect to login page
exit;

?>