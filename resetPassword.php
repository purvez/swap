<?php
//require_once 'forgotPassword.php';

$error = NULL;
$errors = array();
$username = "";
$email = "";
$birthday = "";
$contact = "";
$address = "";
session_start();

if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    //resetPassword($vkey);
    resetPassword($vkey);
}

function resetPassword($vkey)
{
    $con = mysqli_connect("localhost","root","","swapdb");
    $sql = "SELECT * FROM users WHERE vkey='$vkey' LIMIT 1";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    header('location: resetPasswordForm.php');
    exit(0);
}

?>
