<?php 
include 'config.php';
?>
<?php
if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['username']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: home.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: home.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM user WHERE username='$uname' AND password ='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                session_start();
            	$_SESSION['username'] = $uname;
                $_SESSION['Admin'] = $row['is_admin'];
            	header("Location: profile.php");
		        exit();
            }else{
				header("Location: home.php");
		        exit();
			}
		}else{
			header("Location: home.php");
	        exit();
		}
	}
	
}else{
	header("Location: home.php");
	exit();
}
?>
