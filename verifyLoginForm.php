<?php
require_once 'login.php';
$error = NULL;
$errors = array();
$username = "";
$email = "";
$birthday = "";
$contact = "";
$address = "";
$otp = "";
session_regenerate_id();

$email = $_SESSION['email'];
//echo $email;

if(isset($_POST['OTPAuth'])){
    
    $con = mysqli_connect("localhost","root","","swapdb");
    
    //Get Form Data
    $otp = $_POST['otp'];
    
    if(empty($otp)) {
        $errors['otp'] = "OTP Code required";
    }
    
    $authenticate = $_POST['authenticate'];
    
    
    //aa
    $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    
    if( $otp == $user['otp']){
        if ($user['otpExpiry'] == '0'){
            $hello = $user['email'];
            $otp = rand(100000, 999999);
            $sql = "UPDATE users SET otp = $otp, otpExpiry = '1' WHERE email = '". $email ."'";
            $sqlResult = mysqli_query($con, $sql);
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = $user['verified'];
            $_SESSION['vkey'] = $user['vkey'];
            $_SESSION['otpExpiry'] = $user['otpExpiry'];
            //Set flash message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-success'] = "alert-success";
            header('location: index.php');
        } else {
            echo "error";
        }
        
    } else {
        $errors['login_fail'] = "Wrong Credentials";
    }
    
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
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Login Authentication</title>
</head> 

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="verifyLoginForm.php" method="post">
                    <h3 class="text-center">OTP Authentication</h3>
                    <p style="font-size: 1.2em; text-align: center;"> An email with your OTP code has been sent to your email account. </p>
                    <br>
                    
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div> 
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="otp">Enter OTP Code</label>
                        <input type="text" name="otp" " class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $email; ?>" name="authenticate" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="OTPAuth" class="btn btn-primary btn-block btn-lag">Submit OTP</button>
                    </div>
                    <br>
                    </br>
                </form> 
            </div>
        </div>
    </div>
</body>

</html>