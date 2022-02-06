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
    
    if(!preg_match($passwordreg,$password)){
        $errors['password'] = "password must contain minimum eight characters, at least one letter and one number";
    }
    
    if(!preg_match($addressreg,$address)){
        $errors['address'] = "Address does not meet format,only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field";
    }
    
    if(!preg_match($contactreg,$contactNumber)){
        $errors['contactNumber'] = "number is not a singapore number, start with 6, 8 or 9 with 8 maximum numbers";
    }
    
    $username=htmlspecialchars($_POST["username"],ENT_QUOTES);
    $email=htmlspecialchars($_POST["email"],ENT_QUOTES);
    $password=htmlspecialchars($_GET["password"],ENT_QUOTES);
    $address=htmlspecialchars($_POST["address"],ENT_QUOTES);
    $contactNumber=htmlspecialchars($_POST["contactNumber"],ENT_QUOTES);
    $profilePicture=htmlspecialchars($_POST["profilePicture"],ENT_QUOTES);
    $birthday=htmlspecialchars($_POST["birthday"],ENT_QUOTES);
    $role=htmlspecialchars($_POST["role"],ENT_QUOTES);
    
    $query=$con->prepare("update users set email = '".$email."',password = '".$password."',username = '".$username."',address = '".$address."',profilePicture = '".$profilePicture."',contactNumber = '".$contactNumber."',birthday = '".$birthday."',role = '".$role."' where id='".$id."'");
    $query->bind_param('sssssssss', $email, $password, $username, $address, $profilePicture, $contactNumber, $birthday, $role, $id);
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