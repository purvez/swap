
<?php
session_start();
//session_regenerate_id();
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database

if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";

// print_r($_SESSION);
$_SESSION['valid'] == "unverified";
if($_SESSION['otpExpiry'] == "0"){
    header("location:loginform.php");
    session_destroy();
}elseif ($_SESSION['otpExpiry']=='1'){
    if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user") {
        //echo '<script>alert("This page is for admin")</script>';
        header("location:loginform.php");
    }
}


$query="SELECT id,title,stock,details,price,shippingAddress,thumbnail,image1,image2,image3 FROM product"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable
$nrows=$result->num_rows; //calculate number of rows

?>




<?php


$sessionid=$_COOKIE["PHPSESSID"];
$username=$_SESSION["username"];
require_once ('CreateDb.php');
require_once ('component.php');


// create instance of Createdb class
$database = new CreateDb("swapdb", "product");


//print_r($_SESSION);

?>

<!doctype html>
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

<br><br>

<head>
<style>
h1 {
  font-size: 20px;
  font-family:Arial;
  text-align:center
}

</style>
</head>







<h1>WELCOME TO THE TP ECOMMERCE WEBSITE <?php echo $username?>  </h1>




<form action="" method="POST">
<input type="text" id="search" name="search" placeholder="Search For Product" value=""><br>
<button class="submit">Search</button>
</form>



<div class="container">
        <div class="row text-center py-5">
<?php 

$connection = mysqli_connect('localhost','root','','swapdb');


if( !isset($_POST['search']))
{
    $sql="SELECT * FROM product";
    $result1 = mysqli_query($connection,$sql);
    while ($row=mysqli_fetch_assoc($result1)){
        component($row['title'], $row['price'], $row['thumbnail'], $row['id'],$row['details'],$row['shippingAddress']);
    }
}


if (isset($_POST['search']))
{   
    $searchKey= $_POST['search'];
    $sql="SELECT * FROM product WHERE title LIKE '".$searchKey."' OR details LIKE '".$searchKey."' OR shippingAddress LIKE '".$searchKey."'";
    $result = mysqli_query($connection,$sql);
    while ($row = mysqli_fetch_assoc($result))
    {
        component($row['title'], $row['price'], $row['thumbnail'], $row['id'],$row['details'],$row['shippingAddress']);
    }
    
    if(empty($searchKey))
    {
        $sql="SELECT * FROM product";
        $result1 = mysqli_query($connection,$sql);
        while ($row=mysqli_fetch_assoc($result1)){
            component($row['title'], $row['price'], $row['thumbnail'], $row['id'],$row['details'],$row['shippingAddress']);
        }

    }
}

?>
    </div>
</div>













<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


