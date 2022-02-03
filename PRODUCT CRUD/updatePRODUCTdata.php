<?php

require_once("config.php");


if(isset($_POST['update']))
{
    $id = $_GET['ID'];
    $title = $_POST['title'];
    $stock = $_POST['stock'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $shippingAddress = $_POST['shippingAddress'];
    $thumbnail = $_POST['thumbnail'];
    $image1 = $_POST['image1'];
    $image2 = $_POST['image2'];
    $image3= $_POST['image3'];
    $query=$con->prepare("update product set title = '".$title."',stock = '".$stock."',details = '".$details."',price = '".$price."',shippingAddress = '".$shippingAddress."',thumbnail = '".$thumbnail."',image1 = '".$image1."',image2 = '".$image2."',image3 = '".$image3."' where id='".$id."'");
    $query->bind_params('ssssssssss', $title, $stock, $details, $price, $shippingAddress, $thumbnail, $image1, $image2, $image3, $id);
    $query->execute();
    $result = mysqli_query($con,$query);
    
    if($result)
    {
        header("location:productadmin.php");
    }
    else
    {
        echo ' Please Check Your Query ';
    }
}
?>