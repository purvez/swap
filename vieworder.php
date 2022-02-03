<?php
session_start();
require 'config.php';
if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user") {
    header("location:index.php");
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
    $uid=$_SESSION['id'];
    $query="SELECT `id`,`userid`, `productid`, `shippingaddress`, `totalprice`, `title`, `username`, `quantity`, `orderstatus`, `paymode`, `datePurchased` FROM swapdb.order WHERE `userid`='$uid'"; //SQL statement to read the information
    $pQuery=$con->prepare($query); //use prepared statements
    $result=$pQuery->execute(); //execute
    $result=$pQuery->get_result(); //store the results into a variable
    $nrows=$result->num_rows;
    if($nrows>0){
        //draw the table header ONCE only
        echo "<table border=1>";
        echo "<tr>";
        //     echo "<th>id</th>";
        echo "<th>userid</th>";
        echo "<th>productid</th>";
        echo "<th>shippingaddress</th>";
        echo "<th>totalprice</th>";
        echo "<th>title</th>";
        echo "<th>username</th>";
        echo "<th>quantity</th>";
        echo "<th>orderstatus</th>";
        echo "<th>paymode</th>";
        echo "<th>datePurchased</th>";
        echo "</tr>";
        
        While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
            $userid=$row['userid'];
            $productid=$row['productid'];
            $shipping=$row['shippingaddress'];
            $totalprice=$row['totalprice'];
            $title=$row['title'];
            $username=$row['username'];
            $quantity=$row['quantity'];
            $order=$row['orderstatus'];
            $paymode=$row['paymode'];
            $date=$row['datePurchased'];
            $id=$row['id'];
            
            echo "<tr>";
            echo "<td>";
            echo $userid;
            echo "</td>";
            echo "<td>";
            echo $productid;
            echo "</td>";
            echo "<td>";
            echo $shipping;
            echo "</td>";
            echo "<td>";
            echo $totalprice;
            echo "</td>";
            echo "<td>";
            echo $title;
            echo "</td>";
            echo "<td>";
            echo $username;
            echo "</td>";
            echo "<td>";
            echo $quantity;
            echo "</td>";
            echo "<td>";
            echo $order;
            echo "</td>";
            echo "<td>";
            echo $paymode;
            echo "</td>";
            echo "<td>";
            echo $date;
            echo "</td>";
            echo "<td>";
            echo "<a href='refund.php?id=$id'> Cancel order </a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo"<br>";
        echo"<br>"; 
    }
    else
    {
        echo "Order is empty!";
        echo "<br>";
    }

?>