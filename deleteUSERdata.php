<html>
<body>
<?php
include 'config.php';
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}


$USER_ID = $_GET['id'];
$query= "DELETE FROM users WHERE id= '$USER_ID'";
$data=mysqli_query($con,$query);
header("Refresh:0; url=page4admin.php");
session_unset();
session_destroy();


?>
</body>
</html>