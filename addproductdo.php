
<html>
<body>
<?php
require_once "fxaddproduct.php";

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
// $title,$stock,$details,$price,$shippingAddress,$thumbnail,$image1,$image2,$image3
	$checkall=true;
	$checkall=$checkall && checkpost("title",true,"");
	$checkall=$checkall && checkpost("stock",true,"");
	$checkall=$checkall && checkpost("details",true,"");
	$checkall=$checkall && checkpost("price",true,"");
	$checkall=$checkall && checkpost("shippingAddress",true,"");
	$checkall=$checkall && checkpost("thumbnail",true,"");

	if (!$checkall) {
		printmessage("Error checking inputs<br>Please return to the registration form");
		die();
	}
	
// 	(email, password, username, address, profilePicture, contactNumber,birthday,role)
	$title=$_POST['title'];
	$stock=$_POST['stock'];
	$details=$_POST['details'];
	$price=$_POST['price'];
	$shippingAddress=$_POST['shippingAddress'];
	$thumbnail=$_POST['thumbnail'];

	

	addData($title,$stock,$details,$price,$shippingAddress,$thumbnail);	
	
	header("Refresh:0; url=productadmin.php");
	
    

?>
</html>
</body>

