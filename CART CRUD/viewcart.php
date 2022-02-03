<?php
session_start();
session_regenerate_id();
$sessionid=$_COOKIE["PHPSESSID"];
if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user") {
    header("location:loginform.php");
    session_destroy();
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php require_once ("header.php"); ?>


<div class="container">
        <div class="row text-center py-5">
           
        </div>
</div>





<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<?php
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

$sessionid=$_COOKIE["PHPSESSID"];

$query="SELECT * FROM cart WHERE sessionid='$sessionid'"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable
// $query->bind_result($sessionid);//bind para
$nrows=$result->num_rows; //calculate number of rows


if($nrows>0){
    //draw the table header ONCE only
    echo "<table border=1>";
    echo "<tr>";
//     echo "<th>id</th>";
    echo "<th>productid</th>";
    echo "<th>title</th>";
    echo "<th>quantity</th>";
    echo "<th>price</th>";
    echo "<th>total price</th>";
    echo "<th>shippingaddress</th>";
    echo "</tr>";
    
    While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
        
        $id = $row['id'];
        $total=$row['price'] * $row['quantity'];
        
        //productid, title,thumbnail, quantity, price, sessionid,shippingaddress
        echo "<tr>";
//         echo "<td>";
//         echo $row['id']; //coresponding record, column's value and prints it out
//         echo "</td>";
        echo "<td>";
        echo $row['productid'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['title'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['quantity'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['price'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['price'] * $row['quantity']; //calculate total price for that product
        echo "</td>";
        echo "<td>";
        echo $row['shippingaddress'];
        echo "</td>";
        echo "</tr>";
        echo "<td><a href='displayquantity.php?cartID=".$id."'>Change Quantity</a></td>";
        echo "<td><a href='fxdeletecart.php?cartID=".$id."'>Delete Item</a></td>"; 
       
    }
    echo "</table>";
    echo"<br>"; 
    echo"<br>"; 
    
    
    
    
    if(isset ($_SESSION['cart']))
    {
        $finaltotal=array_sum(array_column($_SESSION["cart"],"TotalAmount")); 
        
//         echo "GRAND TOTAL :";
//         echo $finaltotal;
        echo"<h1>GRAND TOTAL: $" . $finaltotal . "</h1>";
        //print_r($_SESSION['cart']);
    }
}


else
{
    echo "Cart is empty!";
    echo "<br>";
}
//print_r($_SESSION['cart']);
?>
<form action="checkoutform.php">
    <input type="submit" name="purchase" value="checkout">
</form>

<html>
<head>
<style>
h1 {
  font-size: 50px;
  font-family:Arial;
}

</style>
</head>
</html>

<form >