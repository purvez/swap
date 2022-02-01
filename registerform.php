<?php
$error = NULL;
$errors = array();
$username = "";
$email = "";
$birthday = "";
$contact = "";
$address = "";
//Include required phpmailer files
require 'phpmailer/includes/PHPMailer.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/Exception.php';
require_once 'emailConfig.php';

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
define('SITE_KEY', '6LfYBDoeAAAAAOCUWKdb9whHBlqRoW0Lh-ommcCg');
define('SECRET_KEY', '6LfYBDoeAAAAAP18fk8xQhfM9D2luI3wmClVGoHD');

session_start();

if(isset($_POST['submit'])){
    
    function getCaptcha($SecretKey){
        $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
        $Return = json_decode($Response);
        return $Return;
    }
    $Return = getCaptcha($_POST['g-recaptcha-response']);
    //var_dump($Return);
    if($Return->success == true && $Return->score > 0.5)
    {
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $rptpasswd = $_POST['rptpasswd'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $contact = $_POST['contactNumber'];
        //$profilePic = $_POST['profilePicture'];
        $birthday = $_POST['birthday'];
        $role = $_POST['role'];
        $PP=$_POST['profilePicture'];
        include 'reGEX.php';
        
        //validation
        if(empty($username)) {
            $errors['username'] = "Username required";
        } /*elseif (!preg_match($usernamereg,$username)){
        $errors['username'] = "Username Does Not Meet Format";
        }*/
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email address is invalid";
        }
        
        if(empty($email)) {
            $errors['email'] = "Email required";
        } //elseif(!preg_match($emailreg,$email)){
        //$errors['email'] = "Please Use Gmail Account";
        //}
        if(empty($passwd)) {
            $errors['passwd'] = "Password required";
        } elseif(!preg_match($passwordreg,$passwd)){
            $errors['passwd'] = "password must contain minimum eight characters, at least one letter and one number";
        }
        if($passwd !== $rptpasswd) {
            $errors['passwd'] = "The two password do not match";
        }
        if(empty($address)) {
            $errors['address'] = "Address required";
        } elseif(!preg_match($addressreg,$address)){
            $errors['address'] = "Address does not meet format,only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field";
        }
        if(empty($contact)) {
            $errors['contactNumber'] = "Contact Number required";
        } elseif(!preg_match($contactreg,$contact)){
        $errors['contactNumber'] = "number is not a singapore number, start with 6, 8 or 9 with 8 maximum numbers";
        }
        if(empty($birthday)) {
            $errors['birthday'] = "Date Of Birth required";
        }
        
        /*if (!preg_match($emailreg,$email)){
         $errors['email'] = "Please Use Gmail Account";
         //die("invalid email");
         }
         if (!preg_match($passwordreg,$passwd)){
         $errors['passwd'] = "password must contain minimum eight characters, at least one letter and one number";
         //die("password must contain minimum eight characters, at least one letter and one number");
         }
         elseif (!preg_match($usernamereg,$username)){
         $errors['username'] = "Username Does Not Meet Format";
         //die("username does not meet format");
         }
         if (!preg_match($addressreg,$address)){
         $errors['address'] = "Address does not meet format,only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field";
         //die("Address does not meet format,only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field");
         }
         if (!preg_match($contactreg,$contact)){
         $errors['contactNumber'] = "number is not a singapore number, start with 6, 8 or 9 with 8 maximum numbers";
         //die("number is not a singapore number, start with 6, 8 or 9 with 8 maximum numbers");
         }
         */
        
        $con = mysqli_connect("localhost","root","","swapdb"); //connect to database
        $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt =  $con->prepare($emailQuery);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userCount = $result->num_rows;
        $stmt->close();
        
        
        if ($userCount > 0) {
            $errors['email'] = "Email already exists";
        }
        
        
        if(count($errors) === 0){
            
            //Generate Vkey
            $vkey= md5(time().$username);
            
            echo $vkey;
            //Insert account into the database
            $passwd = password_hash($passwd, PASSWORD_DEFAULT);
            /*$insert = $con->query("INSERT INTO users (email, password, username, address, contactNumber, birthday, role, vkey)
             VALUES('$email', '$passwd', '$username', '$address', '$contact', '$birthday','$role', '$vkey')");*/
            $sql = "INSERT INTO users (email, password, username, address, contactNumber, birthday, role, vkey, profilePicture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt =  $con->prepare($sql);
            $stmt->bind_param('ssssissss', $email, $passwd, $username, $address, $contact, $birthday, $role, $vkey,$PP);
            
            if($stmt->execute()){
                /*Send Email
                 $to = $email;
                 $subject = "Email Verification";
                 $message = "<a href='http://localhost/swap_present/verify.php?vkey=$vkey'>Register Account</a>";
                 $headers = "From: swapgrp3@gmail.com \r\n";
                 $headers .= "MIME-Version: 1.0" . "\r\n";
                 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                 
                 mail($to, $subject, $message,$headers);
                 
                 header('location:login.php');
                 */
                
                $content = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Verify Email</title>
            </head>
            <body>
                <div class="wrapper">
                    <p>
                        Thank you for signing up on our website. Please click on the link below to verify your email.
                    </p>
                </div>
            </body>
            </html>';
                $content = "<a href='http://localhost/swap/verify.php?vkey=$vkey'>Verify Account</a>";
                
                //Create instance of phpmailer
                $mail = new PHPMailer;
                
                $to = $email;
                //Set mailer to use smtp
                $mail->isSMTP();
                //Define smtp host
                $mail->Host = "smtp.gmail.com";
                
                //enable smtp authentication
                $mail->SMTPAuth = "false";
                
                $mail->SMTPAutoTLS = "false";
                
                //Set type of encryption
                $mail->SMTPSecure = "tls";
                
                //Set port to connect smtp
                $mail->Port = $port;
                
                //Set gmail username
                $mail->Username = $emailSender;
                
                //Set gmail password
                $mail->Password = $passwordSender;
                
                //Set email subject
                $mail->Subject = "Verification of Account";
                $mail->Body = $content;
                $mail->isHTML(true);
                
                
                
                //Set sender email
                $mail->setFrom($emailSender);
                
                //Email Body
                $mail->addAddress($to);
                
                if ($mail->Send()){
                    header('location:register_message.php');
                }else {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
                
                $mail->smtpClose();
            }else{
                echo $con->error;
            }
            
            
        }
    } else {
        /*$KeySecret = "6LcFx0seAAAAAGtjip0Xe4r7W0OVA512cV6bcPiq";
         $responseKey = $_POST['g-recaptcha-response'];
         $UserIP = $_SERVER['REOMTE_ADDR'];
         $url = "https://www.google.com/recaptcha/api/siteverify?secret=$KeySecret&response=$responseKey&remoteip=$UserIP";
         $response = file_get_contents($url);
         $response = json_decode($url);*/
        echo "world";
    }
}

?>

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Register</title>

    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js?render=6LfYBDoeAAAAAOCUWKdb9whHBlqRoW0Lh-ommcCg'></script>
    <!--<script src='https://www.google.com/recaptcha/api.js'></script> -->
    

</head>

<body>

<div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div">
                <form action="registerform.php" method="post">
                    <h3 class="text-center">Register</h3>
                    
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div> 
                    <?php endif; ?>
                            

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="passwd">Password</label>
                        <input type="password" name="passwd" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="rptpasswd">Confirm Password</label>
                        <input type="password" name="rptpasswd" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" value="<?php echo $address; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="contactNumber">Contact</label>
                        <input type="text" name="contactNumber" value="<?php echo $contact; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Date Of Birth</label>
                        <input type="date" name="birthday" value="<?php echo $birthday; ?>" class="form-control form-control-lg">
                    </div>
                    <div type="hidden" class="form-group">
                        <!--<td><select name="role" id="role"> <input type="hidden" value="user">User</option></select> </td>-->
                        <input type="hidden" name="role" value="user">
                    </div>
                    <div class="form-group">
                        <label align="right"> ProfilePic: </label>
                        <td><input type="file" id="profilePicture" name="profilePicture">
                    </div>
                    <div class="form-group">
                        
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control form-control-lg">
                    </div> 
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block btn-lag">Sign Up</button>
                    </div>
                    

                    <p class="text-center">Already a member? <a href="loginform.php">Sign In</a></p>
                </form> 
                <script>
                    grecaptcha.ready(function() {
                    grecaptcha.execute('6LfYBDoeAAAAAOCUWKdb9whHBlqRoW0Lh-ommcCg', {action: 'action_form'})
                    .then(function(token) {
                        // Add your logic to submit to your backend server here.
                        console.log(token);
                        document.getElementById('g-recaptcha-response').value=token;
                    });
                    });
                </script>

            </div>
        </div>
    </div>
<?php 
?>
</body>

</html>
</html>