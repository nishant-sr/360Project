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

// Check if the post ID is provided in the URL
if(isset($_GET['post_id'])) {
    // Retrieve the post ID from the URL
    $post_id = $_GET['post_id'];

    // Function to fetch a post by its ID along with its comments
    function fetch_post_with_comments($conn, $post_id) {
        // Sanitize the input to prevent SQL injection (optional but recommended)
        $post_id = mysqli_real_escape_string($conn, $post_id);

        // Query to fetch the post details
        $sql = "SELECT username, title,body, posts.updated_at, posts.post_id, posts.user_id FROM users JOIN posts ON posts.user_id = users.user_id WHERE post_id = $post_id";
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if($result && mysqli_num_rows($result) > 0) {
            $post = mysqli_fetch_assoc($result);
            // Fetch comments for the post
            $comments = array();
            $sql = "SELECT c.*, u.username AS username, c.user_id AS user_id
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.post_id = $post_id ORDER BY c.updated_at DESC;";
            $result = mysqli_query($conn, $sql);
            if($result && mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $comments[] = array(
                        'comment_id' => $row['comment_id'],
                        'username' => $row['username'],
                        'body' => $row['body'],
                        'updated_at' => $row['updated_at'],
                        'user_id' => $row['user_id'],
                        'post_id' => $row['post_id']
                    );
                }
            }
            // Assign comments to the post array
            $post['comments'] = $comments;
            return $post;
        } else {
            return false; // Post not found
        }
    }

    // Fetch the post details with comments
    $post = fetch_post_with_comments($conn, $post_id);

    // Check if the post exists
    if($post) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <script async src="script/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar bg-primary ">
        <div class="col p-2">
        <a href="index.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
            Main
        </a>
        <a href="timeline.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
            Feed
        </a>
        
        <?php
            if($user == '' || $user == null){
                
                echo'
                <a href="register.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
                    Register
                </a>
                <a href="signin.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
                Sign-In
                </a>';
            }else{
                echo'<a href="profile.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
                '.$user.' 
                </a>
                <a href="create.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
                    Create
                </a>';
            }
        ?>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Post -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $post['title']; ?></h5>
                <p class="card-text"><?php echo $post['body']; ?></p>
                <p class="card-text"><?php echo$post['username']; ?> - <?php echo $post['updated_at']; ?></p>
            </div>
            <?php 
                if ($uid == $post['user_id']) {
                    echo "<a href='edit_post.php?post_id={$post['post_id']}' class='btn btn-primary'>Edit/Delete</a>";
                }
            ?>
        </div>

        <!-- Comments -->
        <div class="mt-4">
            <h2>Comments</h2>

<?php
if (!empty($post['comments'])) {
    foreach ($post['comments'] as $comment) {
        echo "<div class='card mt-3'>
                <div class='card-body'>
                    <p class='card-text'>" . $comment['body'] . "</p>
                    <p class='card-text'>" . $comment['username'] . " - " . $comment['updated_at'] . "</p>";
        // Check if the logged-in user is the owner of the comment
        if ($uid == $comment['user_id']) {
            echo "<a href='edit_comment.php?comment_id={$comment['comment_id']}' class='btn btn-primary'>Edit/Delete</a>";
        }
        echo "</div></div>";
    }
} else {
    echo "<p>No comments for this post.</p>";
}
?>

            <?php
                if($user != '' || $user != null){
                    echo "<div class='mt-4'>
                    <h2>Add a Comment</h2>
                    <form action='add_comment.php' method='post'>
                        <div class='mb-3'>
                            <label for='commentBody' class='form-label'>Your Comment</label>
                            <textarea class='form-control' id='commentBody' name='commentBody' rows='3' required></textarea>
                        </div>
                        <input type='hidden' name='post_id' value='$post_id'>
                        <button type='submit' class='btn btn-primary'>Submit Comment</button>
                    </form>
                </div>";
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo "Post not found.";
    }
} else {
    echo "Post ID not provided.";
}
?>
