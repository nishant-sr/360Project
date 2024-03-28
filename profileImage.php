<?php
    include "config.php";
    session_start();
    $id = $_SESSION['user_id'];
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile"]["name"]);
        $imagedata = file_get_contents($_FILES['profile']['tmp_name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["profile"]["tmp_name"]);
          if($check !== false) {
            
            $uploadOk = 1;
          } else {
            echo "File is not an image.";
            $uploadOk = 0;
          }
          if ($_FILES["profile"]["size"] > 100000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
          }
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
              } else {
                if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                  
                } else {
                  echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
    $null = NULL;
    $sql = $conn->prepare("INSERT INTO userImages (user_id, contentType, image) VALUES(?,?,?)");
    $sql->execute([$id, $imageFileType, $imagedata]);           
    $_SESSION['image'] = $imagedata;
    $_SESSION['imageType'] = $imageFileType;
    header("Location: profile.php");
    exit;  
?>