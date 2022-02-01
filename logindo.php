<?php
require "config.php";
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database

// function printmessage($message) {
//     // echo "<script>console.log(\"$message\");</script>";
//     //echo "<pre>$message<br></pre>";
// }

$checkall=true;
$checkall=$checkall && checkpost("username",true,"");
$checkall=$checkall && checkpost("password",true,"");

if (!$checkall) {
    printmessage("Error checking inputs<br>Please return to login page");
    die();
}

logindo($_POST["username"], $_POST["password"]);

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

function debug() {
    echo "<pre>";
    echo "--------------------------------------------<br>";
    echo "_SESSION<br>";
    print_r($_SESSION);
    echo "_COOKIE<br>";
    print_r($_COOKIE);
    echo "session_name()= " . session_name();
    echo "<br>";
    echo "session_id()= " . session_id();
    echo "<br>";
    echo "</pre>";
}

function logindo($username, $password) {
    
    require "config.php";
    require "fxprinttable.php";
   
    function printerror($message, $con) {
        echo "<pre>";
        echo "$message<br>";
        if ($con) echo "FAILED: ". mysqli_error($con) . "<br>";
        echo "</pre>";
    }
    
    function printok($message) {
        echo "<pre>";
        echo "--------------------------------------------<br>";
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
    
    $query="SELECT id, email, password, username, address, profilePicture, contactNumber, birthday, role FROM swapdb.users
		WHERE username='$username'";
    $result=mysqli_query($con,$query);
    if (!$result) {
        printerror("Querying $db_database",$con);
        die();
    }
    else printok($query);
    //header( 'Location: displayHome.php');
    
    $nrows=mysqli_num_rows($result);
    echo "<pre>#rows=$nrows</pre>";
    echo "<br>";
    
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
    echo "<pre>";
    //print_r works
    print_r($data);
    //array2texttable($data);
    echo "</pre>";
    
    // ------------------------------------
    // Add username into the global variable $_SESSION
    debug();
    if($data[0]["password"] == $password){
        session_start();
        printok("Started session");
        debug();
        // You should session_start first before inserting into $_SESSION
        $_SESSION["username"]=$data[0]["username"];
        $_SESSION["role"]=$data[0]["role"];
        $_SESSION["id"]=$data[0]["id"];
        $_SESSION["address"]=$data[0]["address"];
        $_SESSION["profilePicture"]=$data[0]["profilePicture"];
        printok("Added username , role , id and address into _SESSION");
        $id=$_SESSION["ID"];
//         $_SESSION["cart"]=$data[1];
        
        
        debug();
        print_r($_SESSION);
        // ------------------------------------
        
        
        mysqli_free_result($result);
        
        mysqli_close($con);
        printok("Closing connection");
        header("Refresh:0; url=index.php");
    }
    else{
        header("location:loginform.php");
    }
//     session_start();
//     printok("Started session");
//     debug();
//     // You should session_start first before inserting into $_SESSION
//     $_SESSION["username"]=$data[0]["username"];
//     $_SESSION["role"]=$data[0]["role"];
//     $_SESSION["id"]=$data[0]["id"];
//     $_SESSION["address"]=$data[0]["address"];
//     $_SESSION["profilePicture"]=$data[0]["profilePicture"];
//     printok("Added username , role , id and address into _SESSION");
//     $id=$_SESSION["ID"];
    
    
   
//     debug();
//     print_r($_SESSION);
//     // ------------------------------------
   
    
//     mysqli_free_result($result);
    
//     mysqli_close($con);
//     printok("Closing connection");
//     header("Refresh:0; url=index.php");

//     if ($_SESSION["role"] == "admin") {
//         header("location:page4admin.php");
//     }
//     elseif ($_SESSION["role"] == "user") {
//         header("location:update4defaultuser.php");
//     }
//     else {
//         header("location:index.php?error=invaliduser");
//     }
   
}

?>