<?php
    require_once("config.php");
    $commentID = $_GET['updateid'];
    $query = " select * from review where id='".$commentID."'";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $id = $row['id'];
        $userID= $row['userID'];
        $productID=$row['productID'];
        $username=$row['username'];
        $content=$row['content'];
        $datePosted=$row['datePosted'];
        $rating=$row['rating'];
        $product=$row['product'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" a href="CSS/bootstrap.css"/>
    <title>Document</title>
</head>
<body class="bg-dark">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <div class="card mt-5">
                        <div class="card-title">
                            <h3 class="bg-success text-white text-center py-3"> Update Form in PHP</h3>
                        </div>
                        <div class="card-body">
                            <form action="updateCOMMENTdata.php?ID=<?php echo $id ?>&productID=<?php echo $productID?>&userID=<?php echo $userID?>" method="post">
                               Content:<input type="text" class="form-control mb-2" placeholder=" content " name="content" value="<?php echo $content ?>"><br>
                                Date:<input type="date" class="form-control mb-2" placeholder=" YYYY-MM-DD " name="datePosted" value="<?php echo $datePosted ?>"><br>
                               Rating: <select name="rating" id="rating" value="<?php echo $rating ?>"
 											<option value="1">1</option>
 											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option></select>
                                          <br>
									 <button class="btn btn-primary" name="update">Update</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>

