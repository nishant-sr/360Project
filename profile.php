<?php
include 'config.php';
session_start();
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
      <a href="index.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Main
      </a>
      <a href="timeline.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Feed
      </a>
      <a href="sign.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Signup/Signin
      </a>
      <a href="profile.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        profile
      </a>
      <a href="create.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Create Page
      </a>
      <a href="admin.html" class="link-light link-underline-opacity-25 link-underline-opacity-100-hover p-2">
        Admin
      </a>
    </div>
  </nav>
  <header>
    <h1>User Profile</h1>
  </header>
  <?php
    
  ?>

  <section>
    <p>Username: <?php echo $_SESSION['username'] ?></p>
  </section>
</body>
</html>