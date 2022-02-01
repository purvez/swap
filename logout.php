<?php

setcookie("PHPSESSID", NULL, time()-30*24*60*60, "/");
setcookie("colour", NULL, time()-30*24*60*60, "/");
setcookie("weather", NULL, time()-30*24*60*60, "/");



printmessage("Before session_destroy");
session_start();
debug();

printmessage("Calling session_destory");
session_unset();
session_destroy(); 

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
?>

