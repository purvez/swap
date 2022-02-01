	<!---
<b><i>Process registration</i></b>
--->
<html>
<body>
<?php

session_start();

require_once "fxaddtocart.php";



function printmessage($message) {
	// echo "<script>console.log(\"$message\");</script>";
	echo "<pre>$message<br></pre>";
}

// return true if checks ok
function checkpost($input, $mandatory, $pattern) {

	$inputvalue=$_POST[$input];

	if (empty($inputvalue)) {
		printmessage("$input field is empty");
		if ($mandatory) return false;
		else printmessage("but $input is not mandatory");
	}
	if (strlen($pattern) > 0) {
		$ismatch=preg_match($pattern,$inputvalue);
		if (!$ismatch || $ismatch==0) {
			printmessage("$input field wrong format <br>");
			if ($mandatory) return false;
		}
	}
	return true;
}

	$checkall=true;
// 	$checkall=$checkall && checkpost("content",true,"");
// 	$checkall=$checkall && checkpost("datePosted",true,"");
// 	$checkall=$checkall && checkpost("rating",true,"");
	
	
	require_once("config.php");
	$con = mysqli_connect("localhost","root","","swapdb");
	$productID = $_GET['productID'];
	$query = " select * from product where id=$productID";
	$result = mysqli_query($con,$query);
	while($row=mysqli_fetch_assoc($result))
	{
	    $id = $row['id'];
	    $title= $row['title'];
	    $stock=$row['stock'];
	    $details=$row['details'];
	    $thumbnail=$row["thumbnail"];
	    $price=$row['price'];
	    $shippingAddress=$row['shippingAddress'];
	    $address=$_SESSION["address"];
	    $amount=1;
	}
	
	
// 	$userID, $productID, $username, $content, $datePosted, $rating, $product
	$productID=$_GET["productID"];
	$productName=$title;
	$shippingAddress=$_SESSION["address"];
	$productStock=$stock;
	$thumbnail=$thumbnail;
// 	$details=$details;
	$price=$price;
	$quantity=$amount;
	$sessionID=$_COOKIE["PHPSESSID"];
	
	

	//addCart($productID, $productName, $thumbnail, $quantity, $price, $sessionID,$shippingAddress);
	
	if(isset($_SESSION["cart"]))
	{   
	    $myitems=array_column($_SESSION["cart"],"ItemName");
	    if(in_array($productName,$myitems))
	    {
	        echo"<script>
                    alert('Item Already Added');
                    window.location.href='index.php';
                </script>";
	    }
	    else
	    {
	    $count=count($_SESSION['cart']);
	    $_SESSION['cart'][$count]=array('ItemName'=>$productName,'Price'=>$price,'Quantity'=>$quantity,'TotalAmount'=>$price * $quantity, 'productID'=>$productID);
	    echo"<script>
                    alert('Item Added!');
                    window.location.href='index.php';
                </script>";
	    addCart($productID, $productName, $thumbnail, $quantity, $price, $sessionID,$shippingAddress);
	    }
	}
	else //to create a session called cart and add the first array inside!
	{
	    //$_SESSION['cart'][0]=array('ItemName'=>$productName,'Price'=>$price,'Quantity'=>$quantity,'TotalAmount'=>$price * $quantity);
	    $_SESSION['cart'][$count]=array('ItemName'=>$productName,'Price'=>$price,'Quantity'=>$quantity,'TotalAmount'=>$price * $quantity, 'productID'=>$productID);
	    echo"<script>
                    alert('Item Added!');
                    window.location.href='index.php';
                </script>";
	    addCart($productID, $productName, $thumbnail, $quantity, $price, $sessionID,$shippingAddress);
	}
	    
	header("Refresh:0; url=index.php");
	
	//comment

?>
</html>
</body>



