<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
<?php require_once ("homeheader.php"); ?>
</div>

<?php
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
session_start();

// set time-out period (in seconds)
$inactive = 120;

// check to see if $_SESSION["timeout"] is set
if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: loginform.php");
    }
}

$_SESSION["timeout"] = time();

?>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<html>
<head>
	<style>
	form {
		width: 25%;
		clear: both;
	}
	input  {
		width: 100%;
		clear: both;
	}
	</style>
</head>
<body>
<br>
	<b>REGISTERING PRIVILEDGED USER AND ROLES</b><br>
	<form action="registerADMINdo.php" method="post">
		Username: <input type="text" name="username" required><br>
		Password: <input type="text" name="password" required><br>
		Email: <input type="email" name="email" required><br>
		Address: <input type="text" name="address" required><br>
		ProfilePicture: <input type="file" name="profilePicture" required><br>
		ContactNumber: <input type="number" name="contactNumber" required><br>
		Birthday:  <input type="date" name="birthday" /><br>
		Role: <select name="role" id="role"><br>
		<option value="admin">Admin</option>
		<option value="user">User</option>
		<option value="productadmin">Product Admin</option>
		<option value="reviewadmin">Review Admin</option>
		</select><br>
		<input type="submit" value="Insert Record" >
	</form>
</body>

<body> 


<?php
if ($_SESSION['role']!="admin") {
    echo '<script>alert("This page is for admin")</script>';
    header("location:index.php");
    //session_destroy();
}

$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

$query="SELECT id,email,password,username,address,profilePicture,contactNumber,birthday,role FROM USERS"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable


$nrows=$result->num_rows; //calculate number of rows
echo "number of rows=$nrows<br>";

if($nrows>0){
    //draw the table header ONCE only
    echo "<table border=1>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>email</th>";
    echo "<th>password</th>";
    echo "<th>username</th>";
    echo "<th>address</th>";
    echo "<th>profilePicture</th>";
    echo "<th>contactNumber</th>";
    echo "<th>birthday</th>";
    echo "<th>role</th>";
    echo "<th colspan = '2'>action</th>";
    echo "</tr>";
    
    While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
        
        $id = $row['id'];
        $email= $row['email'];
        $password=$row['password'];
        $username=$row['username'];
        $address=$row['address'];
        $profilePicture=$row['profilePicture'];
        $contactNumber=$row['contactNumber'];
        $birthday=$row['birthday'];
        $role=$row['role'];
        
        echo "<tr>";
        echo "<td>";
        echo $row['id']; //coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['email'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['password'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['username'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['address'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['profilePicture'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['contactNumber'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['birthday'];
        echo "<td>";
        echo $row['role'];
        echo "<td><a href='editUSER.php?updateid=".$id."'>update</a></td>";
        echo "<td><a href='deleteUSERdata.php?id=".$id."'>delete</a></td>";
        
        //ITEM_NAME, STOCK, UNITPRICE, COSTPRICE, SHORT_DESC, MERCHANT
  
        echo "</tr>";
        
       
    }
    echo "</table>";
    
    
}
else{
    echo "0 records<br>";
}

?>
</body>
<br>



</html>