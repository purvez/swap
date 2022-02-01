<?php 
    require_once("config.php");
    $UserID = $_GET['updateid'];
    $query = " select * from users where id='".$UserID."'";
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
                           <form action="updateUSERdata.php?ID=<?php echo $id ?>" method="post">
                               Email:<input type="text" class="form-control mb-2" placeholder=" Email " name="email" value="<?php echo $email ?>"><br>
                                Username:<input type="text" class="form-control mb-2" placeholder=" Username " name="username" value="<?php echo $username ?>"><br>
                                Address:<input type="text" class="form-control mb-2" placeholder=" Address " name="address" value="<?php echo $address ?>"><br>
                                  Password:<input type="text" class="form-control mb-2" placeholder=" Password " name="password" value="<?php echo $password ?>"><br>
                                       ProfilePicture: <input type="text" class="form-control mb-2" placeholder=" Profile Picture " name="profilePicture" value="<?php echo $profilePicture ?>"><br>
                                        ContactNumber:<input type="text" class="form-control mb-2" placeholder=" Contact Number " name="contactNumber" value="<?php echo $contactNumber ?>"><br>
                                        Birthday:  <input type="date" name="birthday" />
                                        Role: <select name="role" id="role">
                                        <option value="admin">Admin</option>
										<option value="user">User</option>
										<option value="productadmin">Product Admin</option>
										<option value="reviewadmin">Review Admin</option>
										</select><br>
										
									 <button class="btn btn-primary" name="update">Update</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>

