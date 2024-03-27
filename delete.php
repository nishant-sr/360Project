<?php
    include "config.php";
    session_start();
    $id = $_SESSION['id'];
    $sql = "DELETE FROM user WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if($_SESSION['Admin']==1){
            header("Location: admin.php");
        }
        else {header("Location: home.php");}
    } else {
    echo "Failed: " . mysqli_error($conn);
    }

?>