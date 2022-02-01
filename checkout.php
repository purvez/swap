<?php
require 'config.php';
session_start();
$result=mysqli_select_db($con, $db_database);

if(isset($_POST['shipping']) && isset($_POST['postal']) && isset($_POST['card']) && isset($_POST['cvc']) && isset($_POST['expiry'])){
    //inserting order into the table
    $_SESSION['shipping']=$_POST['shipping'];
    $_SESSION['postal']=$_POST['postal'];
    $_SESSION['card']=$_POST['card'];
    $_SESSION['cvc']=$_POST['cvc'];
    $_SESSION['expiry']=$_POST['expiry'];
    $date = date("Y-m-d H:i:s");
    $cart_array=$_SESSION['cart'];
    foreach($_SESSION['cart'] as $key => $values){
        $query=$con->prepare("INSERT INTO `order`(`userid`, `productid`, `shippingaddress`, `totalprice`, `title`, `username`, `quantity`, `orderstatus`, `paymode`, `datePurchased`)
        VALUES (?,?,?,?,?,?,?,?,?,?)");
        
        $title=$values['ItemName'];
        $productid=$values['productID'];
        $totalprice=$values['TotalAmount'];
        $quantity=$values['Quantity'];
        $userid=$_SESSION['id'];
        $username=$_SESSION['username'];
        $paymode="Credit card";
        $order="Delivering";
        $shipping=$_POST['shipping'];
        $date=date("Y-m-d H:i:s");
        
        $query->bind_param('ssssssssss', $userid, $productid, $shipping, $totalprice, $title, $username, $quantity,$order,$paymode,$date);
        $query->execute();
    }
    
    foreach($_SESSION['cart'] as $key => $values)
    {
        $query=$con->prepare("UPDATE Product SET stock = ( stock - ? ) WHERE title = ? ");
        $title=$values['ItemName'];
        $quantity=$values['Quantity'];
        $query->bind_param('ss', $quantity, $title);
        $query->execute();
    }
    
    
    //functions that occur once checkout function has been completed
    unset($_SESSION['cart']); //delete cart once add everything to checkout
    session_regenerate_id(); // regenerate session id once done
    header('location:viewcart.php'); //go back to home once checksout
}

else{
    echo"<script>alert('INPUT ERROR')</script>";
    header('location:viewcart.php');
}
?>