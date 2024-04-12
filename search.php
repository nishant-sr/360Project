<?php
include 'config.php';
session_start();

$query = $_GET['query'];

// Search for posts by title or users by username
$sql = "SELECT * FROM posts WHERE title LIKE '%$query%' OR user_id IN (SELECT user_id FROM users WHERE username LIKE '%$query%') ORDER BY updated_at DESC";
$res = $conn->query($sql);

// Display search results
while ($row = $res->fetch_assoc()) {
    echo "
    <div class='card' style='width: 18rem;'>
        <div class='card-body'>
            <h5 class='card-title'>" . $row["title"] . "</h5>
            <p class='card-text'>By: " . $row["user_id"] . "</p>
            <a href='post.php?post_id=" . $row['post_id'] . "' class='btn btn-primary'>View</a>
        </div>
    </div>";
}
?>
