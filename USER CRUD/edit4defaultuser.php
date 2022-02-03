<?php 
    require_once("config.php");
    $UserID = $_GET['updateid'];
    $query=$con->prepare( " select * from users where id='".$UserID."'");
    $query->bind_params('s', $UserID);
    $query->execute();
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $id = $row['id'];
        $email= $row['email'];
        $password=$row['password'];
        $username=$row['username'];
        $address=$row['address'];
        $profilePicture=$row['profilePicture'];
        $contactNumber=$row['contactNumber'];
        $birthday=$row['birthday'];
        $role=$row['role'];
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
                           <form action="updateUSERdata.php?ID=<?php echo $UserID ?>" method="post">
                               Email:<input type="text" class="form-control mb-2" placeholder=" Email " name="email" value="<?php echo $email ?>"><br>
                                Username:<input type="text" class="form-control mb-2" placeholder=" Username " name="username" value="<?php echo $username ?>"><br>
                                Address:<input type="text" class="form-control mb-2" placeholder=" Address " name="address" value="<?php echo $address ?>"><br>
                                  Password:<input type="text" class="form-control mb-2" placeholder=" Password " name="password" value="<?php echo $password ?>"><br>
                                       ProfilePicture: <input type="file" class="form-control mb-2" placeholder=" Profile Picture " name="profilePicture" value="<?php echo $profilePicture ?>"><br>
                                        ContactNumber:<input type="text" class="form-control mb-2" placeholder=" Contact Number " name="contactNumber" value="<?php echo $contactNumber ?>"><br>
                                        Birthday:<input type="date" class="form-control mb-2" placeholder="YYYY-MM-DD" name="birthday" value="<?php echo $birthday ?>"<br>
                                        Role: <select name="role" id="role"><br>
										<option value="user">User</option></select>
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

