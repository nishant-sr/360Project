<?php
// Include your database configuration file
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);
    
    // Check if the username already exists in the database
    $check_query = "SELECT * FROM users WHERE username=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $uname);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Username already exists, handle it (e.g., display error message)
        echo "Error: Username already exists.";
    } else {
        // Username does not exist, proceed with user registration

        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare and execute the SQL statement to insert the new user
        $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ss", $uname, $hashed_password);
        $insert_stmt->execute();

        // Retrieve the user_id of the newly inserted user
        $user_id = $conn->insert_id;

        // Store user information in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $uname;
        $_SESSION['is_admin'] = $row['is_admin'];

        // Redirect to the profile page
        header("Location: profile.php");
        exit;
    }
} else {
    echo "Error: Invalid request method.";
}
?>
