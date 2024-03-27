<?php
// Include your database configuration file
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if(isset($_SESSION['user_id'])) {
        // Retrieve user ID from session
        $user_id = $_SESSION['user_id'];

        // Validate and sanitize the input data
        $postTitle = htmlspecialchars($_POST['postTitle']);
        $postBody = htmlspecialchars($_POST['postBody']);

        // Prepare and execute the SQL statement to insert the new post
        $sql = "INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $postTitle, $postBody);
        if ($stmt->execute()) {
            // Retrieve the auto-generated post_id
            $post_id = $conn->insert_id;
            // Redirect to the page of the newly created post
            header("Location: post.php?post_id=$post_id");
            exit;
        } else {
            // Error inserting post
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // User not logged in
        echo "Error: User not logged in.";
    }
} else {
    // Invalid request method
    echo "Error: Invalid request method.";
}
?>
