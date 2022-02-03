<?php
/*
setcookie("PHPSESSID", NULL, time()-30*24*60*60, "/");
setcookie("colour", NULL, time()-30*24*60*60, "/");
setcookie("weather", NULL, time()-30*24*60*60, "/");



printmessage("Before session_destroy");
session_start();
debug();
$email = $_SESSION['email'];
$sql = "UPDATE users SET otp = $otp, otpExpiry = '0' WHERE email = $email";
$sqlResult = mysqli_query($con, $sql);

printmessage("Calling session_destory");
session_unset();
session_destroy(); 
$con = mysqli_connect("localhost","root","","swapdb");

printmessage("After session_destroy");
debug();

function debug() {
	echo "<pre>";
	echo "--------------------------------------------<br>";
	echo "_SESSION<br>";
	print_r($_SESSION);
	echo "_COOKIE<br>";
	print_r($_COOKIE);
	echo "session_name()= " . session_name();
	echo "<br>";
	echo "session_id()= " . session_id();
	echo "<br>";
	echo "</pre>";
}

function printmessage($message) {
	// echo "<script>console.log(\"$message\");</script>";
	echo "<pre>$message<br></pre>";
}


header("Refresh:0; url=loginform.php");
*/
session_start();
logoff();

function logoff() {
    
    
    $email = $_SESSION['email'];
    echo $email;
    //$email = $_SESSION['email'];
    $con = mysqli_connect("localhost","root","","swapdb");
    $sql = "UPDATE users SET otpExpiry = '0' WHERE email = '".$email."'";
    $sqlResult = mysqli_query($con, $sql);
    session_destroy();
    header("Refresh:0; url=loginform.php");
    
}

?>

