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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
  <div class="container text-center p-2">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
      <header>
        <h1>Main Page</h1>
        <p>Brief welcome section for aesthetic purposes.</p>
      </header>
        
      <h2>Spotlight of Some Posts</h2>
      <div div class="d-flex p-2">
            <?php
                $sql = "SELECT * FROM posts LIMIT 3;";
                $res = $conn->query($sql);
                while($row = $res->fetch_assoc()){
                    echo 
                    "<div class='card' style='width: 18rem;'>
                        <div class='card-body'>
                        <h5 class='card-title'>".$row["title"]."</h5>
                        <a href='post.php?post_id=".$row['post_id']."' class='btn btn-primary'>View</a>
                        </div>
                    </div>";
                }

              ?>
      </div>
  </div>
</body>
</html>