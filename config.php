<?php

$servername = "localhost";
$username = "72899685";
$password = "72899685";
$dbname = "db_72899685";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
?>