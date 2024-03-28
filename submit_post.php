<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];


        $postTitle = htmlspecialchars($_POST['postTitle']);
        $postBody = htmlspecialchars($_POST['postBody']);


        $sql = "INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $postTitle, $postBody);
        if ($stmt->execute()) {

            $post_id = $conn->insert_id;

            header("Location: post.php?post_id=$post_id");
            exit;
        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {

        echo "Error: User not logged in.";
    }
} else {

    echo "Error: Invalid request method.";
}
?>
