<?php require_once 'resetPassword.php';
$error = NULL;
$errors = array();
$username = "";
//$email = "";
$birthday = "";
$contact = "";
$address = "";
echo "hello";
$email = $_SESSION['email'];
//echo $email;
//session_start();
$con = mysqli_connect("localhost","root","","swapdb");

if (isset($_POST['reset-password-btn']))
{
    $con = mysqli_connect("localhost","root","","swapdb");
    $passwd = $_POST['passwd'];
    $rptpasswd = $_POST['rptpasswd'];

    if(empty($passwd) || empty($rptpasswd)) {
        $errors['passwd'] = "Password required";
    }
    if($passwd !== $rptpasswd) {
        $errors['passwd'] = "The two password do not match";
    }

    $passwd = password_hash($passwd, PASSWORD_DEFAULT);
    $email = $_SESSION['email'];

    if (count($errors) == 0) {
        $sql = "UPDATE users SET password='$passwd' WHERE email='$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            header('location: login.php');
            exit(0);
        }
    }
}

//a
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Login</title>
</head> 

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="resetPasswordForm.php" method="post">
                    <h3 class="text-center">Reset Your Password</h3>

                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div> 
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="passwd">New Password</label>
                        <input type="password" name="passwd" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="rptpasswd">Confirm New Password</label>
                        <input type="password" name="rptpasswd" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="reset-password-btn" class="btn btn-primary btn-block btn-lag">Reset Password</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</body>
</html>

/