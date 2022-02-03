<?php require_once ("homeheader.php"); ?>

<?php 
//check for user role as productadmin then if matches allow access to this page if not redirect to loginform
session_start();

// //Defining debug function for troubleshooting
// function debug() {
//     echo "<pre>";
//     echo "--------------------------------------------<br>";
//     echo "_SESSION<br>";
//     print_r($_SESSION);
//     echo "_COOKIE<br>";
//     print_r($_COOKIE);
//     echo "session_name()= " . session_name();
//     echo "<br>";
//     echo "session_id()= " . session_id();
//     echo "<br>";
//     echo "</pre>";
// }
//test
/*
echo "<pre><b>For product admins only</b><br></pre>";

if (isset($_SESSION["username"]) && $_SESSION["role"]=="productadmin")
{
    echo "<pre><h3>You are clear to access this page, <u>" . $_SESSION['username']. "</u></h3></pre>";
//     debug();
}
elseif (!isset($_SESSION["username"]))
{
    echo "<pre><h3><a href=loginform.php>You have not logged in. Please go back to login page</a></h3></pre>";
//     debug();
    die("");
}
else {
    echo "<pre><h3><a href=loginform.php>You have not logged in as an administrator. This page is only for authorised administrators</a></h3></pre>";
//     debug();
    die("");
}
*/
//after initial checks are successful => user is a product admin
if ($_SESSION['role']!="productadmin") {
    echo '<script>alert("This page is for product admin")</script>';
    header("location:index.php");
    //session_destroy();
}
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

$query="SELECT id,title,stock,details,price,shippingAddress,thumbnail,image1,image2,image3 FROM product"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable

$nrows=$result->num_rows; //calculate number of rows
echo "number of rows=$nrows<br>";

if($nrows>0){
    //draw the table header ONCE only
    echo "<table border=1>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>title</th>";
    echo "<th>stock</th>";
    echo "<th>details</th>";
    echo "<th>price</th>";
    echo "<th>shippingAddress</th>";
    echo "<th>thumbnail</th>";
    echo "</tr>";
    
    While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
        
        $id = $row['id'];
        $title= $row['title'];
        $stock=$row['stock'];
        $details=$row['details'];
        $price=$row['price'];
        $shippingAddress=$row['shippingAddress'];
        $thumbnail=$row['thumbnail'];
        
        
        echo "<tr>";
        echo "<td>";
        echo $row['id']; //coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['title'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['stock'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['details'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['price'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['shippingAddress'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['thumbnail'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td><a href='editPRODUCT.php?updateid=".$id."'>update</a></td>";
        echo "<td><a href='deletePRODUCTdata.php?id=".$id."'>delete</a></td>";
        
        //ITEM_NAME, STOCK, UNITPRICE, COSTPRICE, SHORT_DESC, MERCHANT
        
        echo "</tr>";
        
        
    }
    echo "</table>";
    
    
}
else{
    echo "0 records<br>";
}
?>

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

<html>
	<head>
		<title>Insert product page</title>
		
	<!-- Styles here -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <!-- Styles ends --> 
	</head>
	<body>
	<!-- id,title,stock,details,price,shippingAddress,thumbnail,image1,image2,image3 -->
	<b>INSERTING PRODUCT BY PRODUCT ADMIN</b><br>
	<form action="addproductdo.php" method="post">
		Title: <input type="text" name="title" required><br>
		Stock: <input type="number" name="stock" required><br>
		Details: <input type="text" name="details" required><br>
		Price: <input type="text" name="price" required><br>
		Shipping Address: <input type="text" name="shippingAddress" required><br>
		Thumbnail: <input type="file" name="thumbnail" required><br>
		
		<input type="submit" value="Insert Record" >
		
	</form>
</body>
</html>