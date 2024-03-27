<?php
    include 'config.php';
    session_start();
    $id = $_SESSION['id'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = ?, username=? WHERE user_id = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ssi", $hashed_password, $username, $id);
            if($stmt->execute()){
                $_SESSION['username'] = $username;
                header("Location: profile.php");
            } else {
                echo "Failed: " . $stmt->error;
            }
        } else {
            echo "Failed: " . $conn->error;
        }
?>
