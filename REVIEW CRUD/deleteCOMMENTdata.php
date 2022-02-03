<html>
<body>
<?php
session_start();

include 'config.php';
$productID = $_GET['productID'];
$query="SELECT * FROM review where productID=$productID";

$con = mysqli_connect("localhost","root","","swapdb"); //connect to database

if (!$con)
{
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

$userID=$_GET['userID'];

if ( $_SESSION["id"]==$userID || $_SESSION['role']=="admin" )
{
$id = $_GET['id'];
$query=$con->prepare("DELETE FROM review WHERE id= '$id'");
$query->bind_param('s', $id);
$query->execute();
$data=mysqli_query($con,$query);
echo "COMMENT DELETED SUCCESSFULLY!";
header("Refresh:5; url=getcommentdo.php?productID=$productID");
}

else
{
    echo "YOU ARE NOT THE ALLOWED TO DELETE THIS COMMENT!" ;
    header("Refresh:3; url=index.php");  
}

?>
</body>
</html>