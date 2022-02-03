<?php

require_once("config.php");

session_start();

if(isset($_POST['update']))
{
   $id=$_GET["ID"];
   $userID=$_GET["userID"];
   $productID=$_GET["productID"];
   $content=$_POST["content"];
   $datePosted=$_POST["datePosted"];
   $rating=$_POST["rating"];

    
   $query = $con->prepare("update review set content = '".$content."',datePosted = '".$datePosted."',rating = '".$rating."' where id='".$id."'");
   $query->bind_param('ssii', $content, $datePosted, $rating, $id);
   $query->execute();
   $result = mysqli_query($con,$query);
    
    if($result && $_SESSION["role"]=="admin")
    {
        header("location:getcommentdo.php?productID=".$productID."");
        
    }
    elseif($_SESSION["id"]==$userID)
    {
        header("location:getcommentdo.php?productID=$productID");
    }
    else
    {
        echo"YOU ARE ONLY ALLOWED TO EDIT YOU OWN COMMENTS";
        header("Refresh:3; url=index.php");  
    }
    
}
//dawdawd

?>