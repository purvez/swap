<?php
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
session_start();

// set time-out period (in seconds)
$inactive = 120;

// check to see if $_SESSION["timeout"] is set
if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: loginform.php");
    }
}

$_SESSION["timeout"] = time();

?>