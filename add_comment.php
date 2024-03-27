<?php
// Include your database connection code here
include 'config.php';
session_start();

if(isset($_SESSION['username'])&& isset($_SESSION['user_id'])) {
    $user = $_SESSION['username'];
    $uid = $_SESSION['user_id'] ;
  }else{
    $user = null;
    $uid = null;
  }
// Check if the user is logged in
if(isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    // Retrieve user information
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in $_SESSION['uid']
    
    // Check if the form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the required fields are set
        if(isset($_POST['commentBody']) && isset($_POST['post_id'])) {
            // Sanitize input data to prevent SQL injection
            $commentBody = mysqli_real_escape_string($conn, $_POST['commentBody']);
            $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);

            // Insert the comment into the database
            $sql = "INSERT INTO comments (post_id, user_id, body) VALUES ('$post_id', $user_id , '$commentBody')";
            if(mysqli_query($conn, $sql)) {
                // Comment added successfully
                header("Location: post.php?post_id=$post_id");
                // Optionally, you can output a success message here
            } else {
                // Error inserting comment
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            // Required fields not set
            echo "Error: Comment body or post ID not provided.";
        }
    } else {
        // Form not submitted via POST method
        echo "Error: Form not submitted.";
    }
} else {
    // User not logged in
    echo "Error: User not logged in.";
}
exit();
?>