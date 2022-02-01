<html>
<body>
<?php
session_start();
$cartID = $_GET['cartID'];
include 'config.php';


$query="SELECT title FROM cart WHERE id='$cartID'"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable
While($row=$result->fetch_assoc())
{
$title= $row['title'];
}

foreach($_SESSION['cart'] as $key => $value)
{
    if($value["ItemName"]==$title)
    {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart']=array_values($_SESSION['cart']);
        
        $con = mysqli_connect("localhost","root","","swapdb"); //connect to database
        
        if (!$con)
        {
            die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
        }
        
        
        $query=("DELETE FROM cart WHERE id= '$cartID'");
        // $query->bind_param('i',$cartID);
        $data=mysqli_query($con,$query);
        
        echo"<script>
                    alert('Item Removed!');
                    window.location.href='viewcart.php';
                </script>";
    }
    
    else
    {
        include 'config.php';
        $con = mysqli_connect("localhost","root","","swapdb"); //connect to database
        if (!$con)
        {
            die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
        }
        $query=("DELETE FROM cart WHERE id= '$cartID'");
        // $query->bind_param('i',$cartID);
        $data=mysqli_query($con,$query);
        echo "CART ITEM DELETED SUCCESSFULLY!";
        
        header("Refresh:0; url=viewcart.php");
    }
}


?>
</body>
</html>