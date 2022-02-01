<?php
// If you do not call session_start(), you will not be able to access $_SESSION
// session_start() is used for starting a new session and resuming an existing one across PHP pages
session_start();


if (isset($_SESSION["username"]))
{
	echo "<pre><b>Login done</b><br></pre>";
	echo "<pre><h3>Welcome back <u>" . $_SESSION['username']. "</u></h3></pre>";
	debug();
}
else {
	echo "<pre><b>Login not done</b><br></pre>";
	echo "<pre><h3><a href=loginform.php>You have not logged in. Please go back to login page</a></h3></pre>";
	debug();
	die("");
}


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


?>
