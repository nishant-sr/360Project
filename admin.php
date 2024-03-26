<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <script async src="script/script.js"></script>
    <script href="./css/index.css"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar bg-primary ">
    <div class="col p-2">
      <a href="index.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Main
      </a>
      <a href="timeline.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Feed
      </a>
      <a href="sign.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Signup/Signin
      </a>
      <a href="profile.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        profile
      </a>
      <a href="create.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Create Page
      </a>
      <a href="admin.php" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Admin
      </a>
      <form action="logout.php" type="post">
        <button class="btn btn-info" type="submit">logout</button>
      </form>
    </div>
  </nav>
  <div class="container text-center p-2">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <header>
      <h1>Admin View</h1>
      <p>Search for users</p>
      <?php
        if($_SESSION['Admin']==1) {
            $sql = "SELECT * FROM user";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">User Id:</th>
                        <th scope="col">User name:</th>
                        <th scope="col">Password:</th>
                        <th scope="col">Updated At:</th>
                        <th scope="col">Admin Privilages:</th>
                    </tr>
                </thead>
                <tbody>
                    <th><?php echo $row["user_id"]; ?></th>
                    <th><?php echo $row["username"]; ?></th>
                    <th><?php echo $row["password"]; ?></th>
                    <th><?php echo $row["updated_at"]; ?></th>
                    <th>
                        <?php 
                            if($row["is_admin"]==1) {echo 'True';} 
                            else {echo 'False';}  
                        ?>
                    </th>
                </tbody>
                </table>
                <?php
            }

        } 
        else {
            header("Location: home.php");
        }
      ?>
    </header>
  </div>
</body>

</body>
</html>