<?php
// Include your database configuration file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
     $uname = validate($_POST['username']);
     $pass = validate($_POST['password']);
    
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $hashed_password);
    $stmt->execute();
    session_start();
    $_SESSION['username'] = $uname;
    header("Location: profile.php");
    exit;
}

else { echo "Error: " . $sql . "<br>" . $conn->error;}
?>