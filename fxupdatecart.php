<?php    // Creates the user table and setup accounts

session_start();
require_once("config.php");

if(isset($_POST['update']))
{
    
    //sql table
    $cartID = $_GET['cartID'];
    $quantity=$_POST['quantity'];
    
    $query=$con->prepare("update cart set quantity = ? where id = ? "); //prepare statement
    $query->bind_param('si', $quantity, $cartID);
    $query->execute();
    //$query->bind_param('ii',$quantity,$cartID); //bind parameters changes
    //$query=$con->prepare("update cart set quantity = '".$quantity."' where id = '".$cartID."'"); //prepare statement
    //$query->bind_param('ii',$quantity,$cartID); //bind parameters changes
    
    
    
    
    $query="SELECT * FROM cart WHERE id='$cartID'"; //SQL statement to read the information
    $pQuery=$con->prepare($query); //use prepared statements
    $result=$pQuery->execute(); //execute
    $result=$pQuery->get_result(); //store the results into a variable
    While($row=$result->fetch_assoc())
    {
        $title= $row['title'];
        $price= $row['price'];
        $quantity=$row['quantity'];
        $productID=$row['productid'];
    }
    
    //array cofigurations
    foreach($_SESSION['cart'] as $key => $value)
    {
        if($value["ItemName"]==$title)
        {
            //$_SESSION['cart'][$key]=array('ItemName'=>$title,'Price'=>$price,'Quantity'=>$quantity,'TotalAmount'=>$price * $quantity);
            $_SESSION['cart'][$key]=array('ItemName'=>$title,'Price'=>$price,'Quantity'=>$quantity,'TotalAmount'=>$price * $quantity, 'productID'=>$productID);
            
        }
    }
    
    
    
    header("location:viewcart.php");
    
    
    //header("location:index.php");
    
}





?>