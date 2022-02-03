<?php
    require_once("config.php");
    $productID = $_GET['updateid'];
    $query=$con->prepare( " select * from product where id='".$productID."'");
    $query->bind_params('s' ,$productID);
    $query->execute();
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $id = $row['id'];
        $title= $row['title'];
        $stock=$row['stock'];
        $details=$row['details'];
        $price=$row['price'];
        $shippingAddress=$row['shippingAddress'];
        $thumbnail=$row['thumbnail'];
        $image1=$row['image1'];
        $image2=$row['image2'];
        $image3=$row['image3'];
    }

?>
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
                            <form action="updatePRODUCTdata.php?ID=<?php echo $id ?>" method="post">
                               Title:<input type="text" class="form-control mb-2" placeholder=" Title " name="title" value="<?php echo $title ?>"><br>
                                Stock:<input type="text" class="form-control mb-2" placeholder=" Stock " name="stock" value="<?php echo $stock ?>"><br>
                                Details:<input type="text" class="form-control mb-2" placeholder=" Address " name="details" value="<?php echo $details ?>"><br>
                                  Price:<input type="text" class="form-control mb-2" placeholder=" Password " name="price" value="<?php echo $price ?>"><br>
                                       Shipping Address: <input type="text" class="form-control mb-2" placeholder=" Shipping Address " name="shippingAddress" value="<?php echo $shippingAddress ?>"><br>
                                        Thumbnail:<input type="file" class="form-control mb-2" placeholder=" Thumbnail " name="thumbnail" value="<?php echo $thumbnail ?>"><br>
                                         
                                      
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

