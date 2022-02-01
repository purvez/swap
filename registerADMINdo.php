	<!---
<b><i>Process registration</i></b>
--->
<html>
<body>
<?php
require_once "fxaddADMIN.php";

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
// (email, password, username, address, profilePicture, contactNumber,birthday,role)
	$checkall=true;
	$checkall=$checkall && checkpost("email",true,"");
	$checkall=$checkall && checkpost("password",true,"");
	$checkall=$checkall && checkpost("username",true,"");
	$checkall=$checkall && checkpost("address",true,"");
	$checkall=$checkall && checkpost("profilePicture",true,"");
	$checkall=$checkall && checkpost("contactNumber",true,"");
	$checkall=$checkall && checkpost("birthday",true,"");
	$checkall=$checkall && checkpost("role",true,"");
	
	if (!$checkall) {
		printmessage("Error checking inputs<br>Please return to the registration form");
		die();
	}
	
// 	(email, password, username, address, profilePicture, contactNumber,birthday,role)
	$email=$_POST['email'];
	$password=$_POST['password'];
	$username=$_POST['username'];
	$address=$_POST['address'];
	$profilePicture=$_POST['profilePicture'];
	$contactNumber=$_POST['contactNumber'];
	$birthday=$_POST['birthday'];
	$role=$_POST['role'];
	

	addData($email,$password,$username,$address,$profilePicture,$contactNumber,$birthday,$role);	
	
	header("Refresh:0; url=page4admin.php");
	
    

?>
</html>
</body>

