<?php 
include 'config.php';
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: home.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: home.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username='$uname'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id']; // Set user_id session variable
                $_SESSION['username'] = $uname;
                header("Location: profile.php");
                exit();
            } else {
                echo "Incorrect Password";
                exit();
            }
        } else {
            echo "User not found";
            exit();
        }
    }
} else {
    header("Location: home.php");
    exit();
}
?>
