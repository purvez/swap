<?php
$error = NULL;
$errors = array();
$username = "";
$email = "";
$birthday = "";
$contact = "";
$address = "";
require 'phpmailer/includes/PHPMailer.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/Exception.php';
require_once 'emailConfig.php';

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();

//if user clicks on the forgot password button
if (isset($_POST['password-reset'])) {
    $con = mysqli_connect("localhost","root","","swapdb");
    
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email address is invalid";
        
    }
    
    if(empty($email)) {
        $errors['email'] = "Email required";
    }
    
    if (count($errors) == 0) {
        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_assoc($result);
        $vkey = $user['vkey'];
        /*$subject = "Email Verification";
         $message = "<a href='http://localhost/swap_present/resetPassword.php?vkey=$vkey'>Register Account</a>";
         $headers = "From: swapgrp3@gmail.com \r\n";
         $headers .= "MIME-Version: 1.0" . "\r\n";
         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
         
         mail($to, $subject, $message,$headers);*/
        $content = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Verify Email</title>
            </head>
            <body>
                <div class="wrapper">
                    <p>
                        Please click on the link below to reset your password.
                    </p>
                    <a href="http://localhost/swap/resetPassword.php?vkey=$vkey">Reset Password</a>
                </div>
            </body>
            </html>';
        
        $mail = new PHPMailer;
        
        $to = $email;
        //Set mailer to use smtp
        $mail->isSMTP();
        //Define smtp host
        $mail->Host = "smtp.gmail.com";
        
        //enable smtp authentication
        $mail->SMTPAuth = "true";
        
        //Set type of encryption
        $mail->SMTPSecure = "tls";
        
        //Set port to connect smtp
        $mail->Port = $port;
        
        //Set gmail username
        $mail->Username = $emailSender;
        
        //Set gmail password
        $mail->Password = $passwordSender;
        
        //Set email subject
        $mail->Subject = "Reset Password";
        $mail->Body = $content;
        $mail->isHTML(true);
        
        
        
        //Set sender email
        $mail->setFrom($emailSender);
        
        //Email Body
        $mail->addAddress($to);
        
        if ($mail->Send()){
            header('location:register_message.php');
        }else {
            echo "Error..!";
        }
        
        $mail->smtpClose();
        //sendPasswordResetLink($email, $token);
        header('location: password_message.php');
        exit(0);
    }
}
?>

<?php
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
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

    <title>Forgot Password</title>
</head> 

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="forgotPassword.php" method="post">
                    <h3 class="text-center">Recover your password</h3>
                    <p>
                        Please enter your email address you used to sign up on this site
                        and we will assist you in recovering your password.
                    </p>
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div> 
                    <?php endif; ?>
                    <div class="form-group">
                        <input type="email" name="email"  class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="password-reset" class="btn btn-primary btn-block btn-lag">Send Reset Password Link</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</body>

</html>