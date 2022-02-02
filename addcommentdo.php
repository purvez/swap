<?php 
    require_once("config.php");
    $productID = $_GET['productID'];
    $query = " select * from product where id=$productID";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        $id = $row['id'];
        $title= $row['title'];
    }
    
    
?>


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
    
	<b>Add a comment</b><br>
	<form action="registerCOMMENTdo.php?productID=<?php echo $id ?>&title=<?php echo $title ?>" method="post">
		Content: <input type="text" name="content"><br>
    	Rating: <select name="rating" id="rating">
 		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option></select>
		<input type="submit" value="Upload Comment" ><br>
		Product:<?php echo $title ?><br>
		Product ID:<?php echo $id ?>
	</form>
	
	<td><a href='index.php'>Back to home page</a></td>
	
</body>
<!-- Comment here -->

</html>

