<?php
if(isset($_GET['vkey'])){
    //Process Verification
    $vkey = $_GET['vkey'];
    
    //Connect to the database
    $con = mysqli_connect("localhost","root","","swapdb"); //connect to database
    
    $resultSet = $con->query("SELECT verified,vkey FROM users WHERE verified = 0 and vkey = '$vkey' LIMIT 1 ");
    
    if($resultSet->num_rows == 1) {
        //Validate The Email
        $update = $con->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        
        if($update){
            echo "Verification Completed. <a href='http://localhost/swap/loginform.php'>Proceed To Log In Page</a>";
        }else{
            echo $con->error;
        }
    }else{
        
        echo "This Account is already verified. <a href='http://localhost/swap/loginform.php'>Proceed To Log In Page</a>";
        
    }
}else{
    die("Something Went Wrong");
}
?>