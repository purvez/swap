<?php
session_start();
$con = mysqli_connect("localhost","root","","swapdb"); //connect to database
if (!$con){
die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}
$productID = $_GET["productID"];
$query="SELECT * FROM review where productID=$productID"; //SQL statement to read the information
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

if($nrows==0){
    echo "No records yet!<br>Be the first to comment :) !<br>";
    echo "You will be redirected to the home page in 5 seconds!<br>";
    header("Refresh:5; url=index.php"); 
}

if($nrows>0){
    //draw the table header ONCE only
    echo "<table border=1>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>productID</th>";
    echo "<th>username</th>";
    echo "<th>content</th>";
    echo "<th>datePosted</th>";
    echo "<th>rating</th>";
    echo "<th>product</th>";
    echo "</tr>";
    
    While($row=$result->fetch_assoc()){ //fetch assoc allows you to read in a record and allows you to traverse your results row by row
        
        $id = $row['id'];
        $userID= $row['userID'];
        $productID=$row['productID'];
        $username=$row['username'];
        $content=$row['content'];
        $datePosted=$row['datePosted'];
        $rating=$row['rating'];
        $product=$row['product'];
       
        
        echo "<tr>";
        echo "<td>";
        echo $row['id']; //coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['productID'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['username'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['content'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['datePosted'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['rating'];//coresponding record, column's value and prints it out
        echo "</td>";
        echo "<td>";
        echo $row['product'];
        echo "</td>";
        
        
        echo "<td><a href='editCOMMENT.php?updateid=".$id."'>update</a></td>";
        echo "<td><a href='deleteCOMMENTdata.php?id=".$id."&productID=".$productID."&userID=".$userID."'>delete</a></td>";
        //REPORT COMMENT FUNCTION:
        echo "<td><a href='reportCOMMENT.php?reportid=".$id."'Report</a></td>";
     
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

