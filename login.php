<?php
/*
 $error = NULL;
 $errors = array();
 $username = "";
 $email = "";
 $birthday = "";
 $contact = "";
 $address = "";
 session_start();
 
 if(isset($_POST['submit'])){
 //Connect to Database
 $con = mysqli_connect("localhost","root","","swapdb");
 
 //Get Form Data
 $username = $_POST['username'];
 $password = $_POST['password'];
 
 if(empty($username)) {
 $errors['username'] = "Username required";
 }
 if(empty($password)) {
 $errors['password'] = "Password required";
 }
 
 
 if (count($errors) === 0) {
 $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
 $stmt = $con->prepare($sql);
 $stmt->bind_param('ss', $username, $username);
 $stmt->execute();
 $result = $stmt->get_result();
 $user = $result->fetch_assoc();
 // If result matched $myusername and $mypassword
 if(password_verify($password, $user['password'])) {
 // login success
 $_SESSION['id'] = $user['id'];
 $_SESSION['username'] = $user['username'];
 $_SESSION['email'] = $user['email'];
 $_SESSION['verified'] = $user['verified'];
 $_SESSION['role'] = $user['role'];
 //Set flash message
 $_SESSION['message'] = "You are now logged in!";
 $_SESSION['alert-success'] = "alert-success";
 header('location: index.php');
 exit();
 
 } else {
 $errors['login_fail'] = "Wrong Credentials";
 }
 }
 }
 */
?>
<?php
require 'phpmailer/includes/PHPMailer.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/Exception.php';
require_once 'emailConfig.php';

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
//include_once 'loginform.php';
$error = NULL;
$errors = array();
$username = "";
$email = "";
$birthday = "";
$contact = "";
$address = "";

if(isset($_POST['submit'])){
    
    //Connect to Database
    $con = mysqli_connect("localhost","root","","swapdb");
    
    //Get Form Data
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)) {
        $errors['username'] = "Username required";
    }
    if(empty($password)) {
        $errors['password'] = "Password required";
    }
    
    $username=htmlspecialchars($_POST["username"],ENT_QUOTES);
    $password=htmlspecialchars($_POST["password"],ENT_QUOTES);
        
        if (count($errors) === 0) {
            $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('ss', $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if($user['verified'] == '0'){
                $errors['login_fail'] = "Please Verify your account";
            }
            else{
                
            // If result matched $myusername and $mypassword
            if(password_verify($password, $user['password'])) {
                // login success
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['vkey'] = $user['vkey'];
                $_SESSION['birthday'] = $user['birthday'];
                $_SESSION['profilePicture'] = $user['profilePicture'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['address']=$user['address'];
                $_SESSION["otpExpiry"]=$user['otpExpiry'];
                $_SESSION["valid"] = "verified";
                
                //Set flash message
                $_SESSION['message'] = "You are now logged in!";
                $_SESSION['alert-success'] = "alert-success";
                $_SESSION['verified']=$user['verified'];
                $otp = rand(100000, 999999);
                $sql = "UPDATE users SET otp = $otp WHERE email = '". $_POST["username"] ."' OR username = '". $_POST["username"] ."'";
                $sqlResult = mysqli_query($con, $sql);

                $content = "One Time Password for login authentication is: " . $otp;

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
                $mail->Subject = "Verification of Account";
                $mail->Body = $content;
                $mail->isHTML(true);

                //Set sender email
                $mail->setFrom($emailSender);

                //Email Body
                $mail->addAddress($user['email']);

            if ($mail->Send()){
                header('location:verifyLoginForm.php');
            }else {
                echo "Error..!";
            }

            $mail->smtpClose();
                
                //header('location: verifyLoginForm.php');
                exit();

            } else {
                $errors['login_fail'] = "Wrong Credentials";
            }
        }
        }   
    }

?>

<?php
/*
$error = NULL;
if(isset($_POST['submit'])){
    //Connect to Database
    $con = mysqli_connect("localhost","root","","swapdb");
    
    //Get Form Data
    $username = $con->real_escape_string($_POST['username']);
    $passwd = $con->real_escape_string($_POST['passwd']);
    //$role="SELECT role FROM swapdb.users WHERE username = ?";
    $passwd = md5($passwd);
    
    //Query the database
    $resultSet = $con->query("SELECT * FROM users WHERE username = '$username' AND
    password = '$passwd' LIMIT 1"); 
    
    
    if($resultSet->num_rows !=0){
        //process login
        $row = $resultSet->fetch_assoc();
        $verified = $row['verified'];
        $email = $row['email'];
        $date = $row['createDate'];
        $date = strtotime($date);
        $date = date('M d Y', $date);
        
        if($verified == 1){
            function authenticate($username, $passwd)
            {
                if (empty($username) || empty($passwd)) {
                    die("UserName or password is empty!");
                }
                // encrypt password using sha256
                $passwd = md5($passwd);
                $con = mysqli_connect("localhost", "root", "", "swapdb") or die("cannot connect");
                $passwd=$con->real_escape_string($_POST['passwd']);
                $passwd = md5($passwd);
                $sql = $con->prepare("SELECT * FROM users WHERE username='$username' and password='$passwd'");
                $result = $sql->execute();
                $sql->bind_result($id, $email, $passwd, $username, $address, $profilePic, $contactNumber, $birthday, $role, $vkey, $verified, $createDate);
                // If result matched $myusername and $mypassword
                if ($sql->fetch()) {
                    // Register $role, $myusername and redirect to respective user page
                    $_SESSION['role'] = $role;
                    $_SESSION['username'] = $username;
                    if ($_SESSION['role'] == "user") {
                        // redirect user to member page if role is member
                        header("location:index.php");
                    } else if ($_SESSION['role'] == "administrator") {
                        // redirect user to admin page if role is admin
                        header("location:page4admin.php");
                    }
                } else {
                    echo "Inavlid user or wrong password";
                }
            }
            
            $username=$_REQUEST['username'];
            $passwd=$_REQUEST['passwd'];
            authenticate($username, $passwd);
            
        }else{
            $error = "This account has not yet been verified. An email was sent to $email on $date";
        }
    }else {
        //Invalid Credentials
        $error = "The username or password you entered is incorrect";
    }
}*/

//adsda
?>