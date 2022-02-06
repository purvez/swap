


<?php
session_start();

session_regenerate_id();
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database

if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}


if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user"  )
{
    //echo '<script>alert("This page is for admin")</script>';

    header("location:loginform.php");
    session_destroy();
}elseif ($_SESSION['otpExpiry']=='1'){
    if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user") {
        //echo '<script>alert("This page is for admin")</script>';
        header("location:loginform.php");
    }
}

// if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user"  )
// {
//     //echo '<script>alert("This page is for admin")</script>';

//     header("location:loginform.php");
//     session_destroy();
// }elseif ($_SESSION['otpExpiry']=='1'){
//     if ($_SESSION['role']!="admin" && $_SESSION['role']!="productadmin" && $_SESSION['role']!="user") {
//         //echo '<script>alert("This page is for admin")</script>';
//         header("location:loginform.php");
//     }
// }


$query="SELECT id,title,stock,details,price,shippingAddress,thumbnail,image1,image2,image3 FROM product"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable
$nrows=$result->num_rows; //calculate number of rows




// if($nrows>0){
//     //draw the table header ONCE only
//     echo "<table border=1>";
//     echo "<tr>";
//     echo "<th>id</th>";
//     echo "<th>title</th>";
//     echo "<th>stock</th>";
//     echo "<th>details</th>";
//     echo "<th>price</th>";
//     echo "<th>shippingAddress</th>";
//     echo "</tr>";
    
//     While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
        
//         $id = $row['id'];
//         $title= $row['title'];
//         $stock=$row['stock'];
//         $details=$row['details'];
//         $price=$row['price'];
//         $shippingAddress=$row['shippingAddress'];
//         $thumbnail=$row['thumbnail'];
//         $image1=$row['image1'];
//         $image2=$row['image2'];
//         $image3=$row['image3'];
        
//         echo "<tr>";
//         echo "<td>";
//         echo $row['id']; //coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo $row['title'];//coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo $row['stock'];//coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo $row['details'];//coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo $row['price'];//coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo $row['shippingAddress'];//coresponding record, column's value and prints it out
//         echo "</td>";
//         echo "<td>";
//         echo "</td>";
//         echo "<td>";
//         echo "<td><a href='addcommentdo.php?productID=".$id."'>Comment</a></td>";
//         echo "<td><a href='getcommentdo.php?productID=".$id."'>View comments</a></td>";
//         echo "<td><a href='registerTOCARTdo.php?productID=".$id."'>Add to cart</a></td>";
        
//         echo "</tr>";
        
        
       
//     }
//     echo "</table>";
   
   
    
// }
// else{
//     echo "0 records<br>";
// }


$username=$_SESSION["username"];

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


if( !isset($_POST['search']) )
{
    $sql="SELECT * FROM product";
    $result1 = mysqli_query($connection,$sql);
    while ($row=mysqli_fetch_assoc($result1))
    {
        component($row['title'], $row['price'], $row['thumbnail'], $row['id'],$row['details'],$row['shippingAddress']);
    }
}


if (isset($_POST['search']))
{   
    $searchKey= $_POST['search'];
    $sql=("SELECT * FROM product WHERE title LIKE '".$searchKey."' OR details LIKE '".$searchKey."' OR shippingAddress LIKE '".$searchKey."'");
    $result = mysqli_query($connection,$sql);
    while ($row = mysqli_fetch_assoc($result))
    $searchKey=htmlspecialchars($_POST["search"],ENT_QUOTES);
    {
        component($row['title'], $row['price'], $row['thumbnail'], $row['id'],$row['details'],$row['shippingAddress']);
    }
    $query="SELECT * FROM cart WHERE sessionid='$sessionid'"; //SQL statement to read the information
    $pQuery=$con->prepare($query); //use prepared statements
    $result=$pQuery->execute(); //execute
    
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
