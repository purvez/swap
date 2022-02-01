<?php	// Creates the user table and setup accounts


function adduser($email, $password, $username, $address, $profilePicture, $contactNumber, $birthday, $role) {
    
    require "config.php";
    
    function printerror($message, $con) {
        echo "<pre>";
        echo "$message<br>";
        if ($con) echo "FAILED: ". mysqli_error($con). "<br>";
        echo "</pre>";
    }
    
    function printok($message) {
        echo "<pre>";
        echo "$message<br>";
        echo "OK<br>";
        echo "</pre>";
    }
    
    try {
        $con=mysqli_connect($db_hostname,$db_username,$db_password);
    }
    catch (Exception $e) {
        printerror($e->getMessage(),$con);
    }
    if (!$con) {
        printerror("Connecting to $db_hostname", $con);
        die();
    }
    else printok("Connecting to $db_hostname");
    
    $result=mysqli_select_db($con, $db_database);
    if (!$result) {
        printerror("Selecting $db_database",$con);
        die();
    }
    else printok("Selecting $db_database");
    
    // validation for existing user
    $gresult='';
    $query=$con->prepare("Select * from users where username=?");
    $query->bind_param('s',$username);
    $query->execute();
    $result=$query->get_result();
    $gresult=$result->fetch_assoc();
    if($gresult==null){
        $query=$con->prepare("INSERT INTO users (email, password, username, address, profilePicture, contactNumber, birthday, role) VALUES ('$email', '$password', '$username', '$address', '$profilePicture', '$contactNumber', '$birthday', '$role')");
        //$query->bind_param('ssssssss',$email,$username,$password,$address,$profilePicture,$contactNumber,$birthday,$role);
        if ($query->execute()){
            echo "Query executed, Database updated"; //choose your message either reg success or database updated
            echo "register success!";
        }
        else{
            echo $query->error;
            echo "Error executiny query";
        }
    }else{
        echo "Username already exist";
        echo "register unsuccessful!";
    }
    // 	$query="INSERT INTO users (email, password, username, address, profilePicture, contactNumber, birthday, role)
    // 		VALUES ('$email', '$password', '$username', '$address', '$profilePicture', '$contactNumber', '$birthday', '$role')";
    // 	$result=mysqli_query($con,$query);
    // 	if (!$result) {
    // 		printerror("Selecting $db_database",$con);
    // 		die();
    // 	}
    // 	else printok($query);
    
    mysqli_close($con);
    printok("Closing connection");
    
    header("Refresh:3; url=loginform.php");
    

	require "config.php";
	
	function printerror($message, $con) {
		echo "<pre>";
		echo "$message<br>";
		if ($con) echo "FAILED: ". mysqli_error($con). "<br>";
		echo "</pre>";
	}

	function printok($message) {
		echo "<pre>";
		echo "$message<br>";
		echo "OK<br>";
		echo "</pre>";
	}

	try {
	$con=mysqli_connect($db_hostname,$db_username,$db_password);
	}
	catch (Exception $e) {
		printerror($e->getMessage(),$con);
	}
	if (!$con) {
		printerror("Connecting to $db_hostname", $con);
		die();
	}
	else printok("Connecting to $db_hostname");

	$result=mysqli_select_db($con, $db_database);
	if (!$result) {
		printerror("Selecting $db_database",$con);
		die();
	}
	else printok("Selecting $db_database");

// validation for existing user
	$gresult='';
	$query=$con->prepare("Select * from users where username=?");
	$query->bind_param('s',$username);
	$query->execute();
	$result=$query->get_result();
	$gresult=$result->fetch_assoc();
	if($gresult==null){
	    $query=$con->prepare("INSERT INTO users (email, password, username, address, profilePicture, contactNumber, birthday, role) VALUES ('$email', '$password', '$username', '$address', '$profilePicture', '$contactNumber', '$birthday', '$role')");
	    //$query->bind_param('ssssssss',$email,$username,$password,$address,$profilePicture,$contactNumber,$birthday,$role);
	    if ($query->execute()){
	        echo "Query executed, Database updated";
	    }
	    else{
	        echo $query->error;
	        echo "Error executiny query";
	    }
	}else{
	    echo "Username already exist";
	}
// 	$query="INSERT INTO users (email, password, username, address, profilePicture, contactNumber, birthday, role) 
// 		VALUES ('$email', '$password', '$username', '$address', '$profilePicture', '$contactNumber', '$birthday', '$role')";
// 	$result=mysqli_query($con,$query);
// 	if (!$result) {
// 		printerror("Selecting $db_database",$con);
// 		die();
// 	}
// 	else printok($query);

	mysqli_close($con);
	printok("Closing connection");
	echo"register success!";
	header("Refresh:3; url=loginform.php");  

}

?>