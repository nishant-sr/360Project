<?php
include 'config.php';
session_start();
if(isset($_SESSION['username'])&& isset($_SESSION['user_id'])) {
  $user = $_SESSION['username'];
  $uid = $_SESSION['user_id'] ;
}else{
  $user = null;
  $uid = null;
}
$_SESSION['default']="./assets/usericon.webp"
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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

        if($_SESSION['is_admin'] == 1){
          echo"
          <a href='admin.php' class='link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2'>
          Admin
        </a>";
        }
    ?>
    </div>
  </nav>
  <header>
    <h1>User Profile</h1>
  </header>
    <figure class="figure m-1">
      <img
      src=
      "<?php
          if($_SESSION['image']==null) {
            echo $_SESSION['default'];
          }
          else {
            echo "data:image/".$_SESSION['imageType'].";base64,".base64_encode($_SESSION['image']);
          }
      ?>"
      alt="Upload image for it to be visible"
      width="175" 
      height="100"
      >
    </figure>
  <section>
    <p class="m-2">Username: <?php echo $_SESSION['username'] ?></p>
  </section>
  <?php if($_SESSION['is_admin']==1) {echo "<p class='m-2'>Admin</p> <a href='admin.php'><button class='btn btn-info m-2'>Admin view</button></a>";}?>
  <a href="updateUser.html"><button class="btn btn-success m-2">update account</button></a>
  <form action="logout.php" method="post">
    <button class="btn btn-primary m-2" type="submit">Logout</button>
  </form>
  <form action="deleteAccount.php" method="post">
    <button class="btn btn-danger m-2" type="submit">Delete Account</button>
  </form>
  <a href="profileImage.html"><button class="btn btn-warning m-2 btn-block">Upload Image</button></a>   


  <?php
    $sql = "SELECT comments.comment_id, comments.body, comments.post_id, posts.title, comments.updated_at
            FROM comments
            JOIN posts ON comments.post_id = posts.post_id
            WHERE comments.user_id = ? ORDER BY updated_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>Comment History</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><a href='post.php?post_id=".$row['post_id']."'> Commented: ".$row['body']."</a> Under Post: ".$row['title']."</p>";
        }
    } else {
        echo "<p>No comments found.</p>";
    }
  ?>
</body>
</html>