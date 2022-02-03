<?php
session_start();
require_once("config.php");
$userID=$_SESSION["id"];

if(isset($_POST['update']))
{
    $id = $_GET['ID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $profilePicture = $_POST['profilePicture'];
    $contactNumber = $_POST['contactNumber'];
    $birthday = $_POST['birthday'];
    $role = $_POST['role'];
    
    $query=$con->prepare("update users set email = '".$email."',password = '".$password."',username = '".$username."',address = '".$address."',profilePicture = '".$profilePicture."',contactNumber = '".$contactNumber."',birthday = '".$birthday."',role = '".$role."' where id='".$id."'");
    $query->bind_params('sssssssss', $email, $password, $username, $address, $profilePicture, $contactNumber, $birthday, $role, $id);
    $query->execute();
    $result = mysqli_query($con,$query);
    
    if($result && $_SESSION["role"]=="admin")
    {   
        $_SESSION["profilePicture"]=$profilePicture;
        header("location:page4admin.php");
    }elseif($result && $_SESSION["role"]=="productadmin")
    {
        $_SESSION["profilePicture"]=$profilePicture;
        header("location:page4admin.php");
    }elseif($result && $_SESSION["role"]=="reviewadmin")
    {
        $_SESSION["profilePicture"]=$profilePicture;
        header("location:page4admin.php");
    }
    else
    {
        $_SESSION["profilePicture"]=$profilePicture;
        header("location:update4defaultuser.php?updateID=$userID");
    }
}



?>