<?php
// Include your database connection code here
include 'config.php';
session_start();

$uid = $_SESSION['user_id'] ;

// Check if the comment ID is provided in the URL
if (isset($_GET['post_id'])) {
    // Retrieve the post ID from the URL
    $post_id = $_GET['post_id'];

    // Query to fetch the existing post information based on the post ID
    $sql = "SELECT * FROM posts WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$post_id,$uid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the post exists
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        $title = $post['title'];
        $body = $post['body'];
    } else {
        // Redirect the user if the post doesn't exist (optional)
        header("Location: timeline.php");
        exit();
    }
} else {
    // Redirect the user if the post ID is not provided (optional)
    header("Location: timeline.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve the new post body from the form
    $new_body = $_POST['postBody'];
    $new_title = $_POST['postTitle'];

    // Update the post in the database
    $sql = "UPDATE posts SET title = ?, body = ?, updated_at = CURRENT_TIMESTAMP WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $new_title, $new_body, $post_id, $uid);
    $stmt->execute();

    // Redirect the user to the post page after updating the post
    header("Location: post.php?post_id=" . $post['post_id']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Delete the post from the database
    $sql = "DELETE FROM posts WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $uid);
    $stmt->execute();

    // Redirect the user to the post page after deleting the post
    header("Location: timeline.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2>Edit post</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?post_id=' . $post_id; ?>" method="post">
        <div class="mb-3">
            <label for="postTitle" class="form-label">Title</label>
            <textarea class="form-control" id="postTitle" name="postTitle" rows="3" required><?php echo $title; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="postBody" class="form-label">Body</label>
            <textarea class="form-control" id="postBody" name="postBody" rows="3" required><?php echo $body; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
        <button type="submit" name="delete" class="btn btn-danger">Delete post</button>
    </form>
</div>

</body>
</html>
