<html>
<body>
<?php
include 'config.php';
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}


$ITEM_ID = $_GET['id'];
$query= "DELETE FROM product WHERE id= '$ITEM_ID'";
$data=mysqli_query($con,$query);
header("Refresh:0; url=productadmin.php");


?>
</body>
</html>