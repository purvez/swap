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
	
	
	
	if(!preg_match($passwordreg,$password)){
	    $errors['password'] = "password must contain minimum eight characters, at least one letter and one number";
	}
	
	if(!preg_match($addressreg,$address)){
	    $errors['address'] = "Address does not meet format,only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field";
	}
	
	if(!preg_match($contactreg,$contactNumber)){
	    $errors['contactNumber'] = "number is not a singapore number, start with 6, 8 or 9 with 8 maximum numbers";
	}
	
	$username=htmlspecialchars($_POST["username"],ENT_QUOTES);
	$email=htmlspecialchars($_POST["email"],ENT_QUOTES);
	$password=htmlspecialchars($_GET["password"],ENT_QUOTES);
	$address=htmlspecialchars($_POST["address"],ENT_QUOTES);
	$contactNumber=htmlspecialchars($_POST["contactNumber"],ENT_QUOTES);
	$profilePicture=htmlspecialchars($_POST["profilePicture"],ENT_QUOTES);
	$birthday=htmlspecialchars($_POST["birthday"],ENT_QUOTES);
	$role=htmlspecialchars($_POST["role"],ENT_QUOTES);
	
	addData($email,$password,$username,$address,$profilePicture,$contactNumber,$birthday,$role);	
	
	header("Refresh:0; url=page4admin.php");
	
    

?>
</html>
</body>

