<?php
session_start();
session_regenerate_id();
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
$userID=$_GET["updateID"];
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

$query="SELECT id,email,password,username,address,profilePicture,contactNumber,birthday,role FROM USERS WHERE id=$userID"; //SQL statement to read the information
$pQuery=$con->prepare($query); //use prepared statements
$result=$pQuery->execute(); //execute
$result=$pQuery->get_result(); //store the results into a variable
if(!$result){
    die("SELECT query failed<br>".$con->error);
}
else{
    echo "SELECT QUERY SUCCESS<br>";
}

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
        echo "<td><a href='edit4defaultuser.php?updateid=".$userID."'>update</a></td>";
        //ITEM_NAME, STOCK, UNITPRICE, COSTPRICE, SHORT_DESC, MERCHANT
        echo "</tr>";
        
        
       
    }
    echo "</table>";
    
    
}
else{
    echo "0 records<br>";
}

echo"<td><a href='index.php'>Back to home page</a></td>";
?>
<br>
<?php
$pp= $_SESSION["profilePicture"];
?>
  <img src="./upload/<?php echo $pp; ?>" class=\"img-fluid card-img-top\" width="100px"; height="100px"/>