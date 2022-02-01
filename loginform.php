<?php
include 'login.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src='https://www.google.com/recaptcha/api.js?render=6LfYBDoeAAAAAOCUWKdb9whHBlqRoW0Lh-ommcCg'></script>
    <link rel="stylesheet" href="style.css">

    <title>Login</title>
</head> 

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="loginForm.php" method="post">
                    <h3 class="text-center">Login</h3>
                    
                    <?php 
                    require_once 'login.php';
                    if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div> 
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="passwprd">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block btn-lag">Log In</button>
                    </div>
                    <div class="form-group">
                        
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control form-control-lg">
                    </div> 
                    <p class="text-center">Not yet a member? <a href="registerform.php">Sign In</a></p>
                    <div style="font-size: 0.8em; text-align: center;"><a href="forgotPassword.php">Forgot your Password?</a></div>
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
</body>

</html>