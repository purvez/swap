<?php
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}
$id=$_GET['id'];
$query="DELETE FROM `order` WHERE `order`.`id` = $id"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
header("location:updateorder.php");
?>