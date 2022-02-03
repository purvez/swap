	<!---
<b><i>Process registration</i></b>
--->
<html>
<body>
<?php

session_start();

require_once "fxaddcomment.php";

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
	$checkall=$checkall && checkpost("content",true,"");
	$checkall=$checkall && checkpost("datePosted",true,"");
	$checkall=$checkall && checkpost("rating",true,"");
	
	
	if (!$checkall) {
		printmessage("Error checking inputs<br>Please return to the registration form");
		die();
	}
	
// 	$userID, $productID, $username, $content, $datePosted, $rating, $product
	$productID=$_GET["productID"];
	$product=$_GET['title'];
	$userID=$_SESSION["id"];
	$username=$_SESSION["username"];
	//$address=$_SESSION["address"];
	$content=htmlspecialchars($_POST['content'],ENT_QUOTES);
	$datePosted=date("Y-m-d H:i:s");
	$rating=$_POST['rating'];
	$flagged= 0;

	addComment($userID, $productID, $username, $content, $datePosted, $rating, $product);
	
	header("Refresh:0; url=index.php");
	

?>
</html>
</body>

