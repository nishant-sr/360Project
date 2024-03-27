<?php
// Include your database connection code here
include 'config.php';
session_start();

// Check if the comment ID is provided in the URL
if (isset($_GET['comment_id'])) {
    // Retrieve the comment ID from the URL
    $comment_id = $_GET['comment_id'];

    // Query to fetch the existing comment information based on the comment ID
    $sql = "SELECT * FROM comments WHERE comment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the comment exists
    if ($result->num_rows > 0) {
        $comment = $result->fetch_assoc();

        $body = $comment['body'];
    } else {
        // Redirect the user if the comment doesn't exist (optional)
        header("Location: timeline.php");
        exit();
    }
} else {
    // Redirect the user if the comment ID is not provided (optional)
    header("Location: timeline.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the new comment body from the form
    $new_body = $_POST['commentBody'];

    // Update the comment in the database
    $sql = "UPDATE comments SET body = ? WHERE comment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_body, $comment_id);
    $stmt->execute();

    // Redirect the user to the post page after updating the comment
    header("Location: post.php?post_id=" . $comment['post_id']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Comment</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?comment_id=' . $comment_id; ?>" method="post">
        <div class="mb-3">
            <label for="commentBody" class="form-label">Your Comment</label>
            <textarea class="form-control" id="commentBody" name="commentBody" rows="3" required><?php echo $body; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

</body>
</html>
