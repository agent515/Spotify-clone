<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    $account = new Account($conn);
    
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    <script src="assets/js/register.js"></script>
</head>
<body>
        <?php
            if(isset($_POST['registerSubmit'])){
                echo '<script>
                $(document).ready(function(){
                    $("#loginForm").hide();
                    $("#registerForm").show();    
        });
                    </script>';
            }
            else {
                echo '<script>
                    $(document).ready(function(){
                    $("#loginForm").show();
                    $("#registerForm").hide();    
        });
                    </script>';
            }
        ?>
    <!-- <script>
        $(document).ready(function(){
            $("#loginForm").show();
            $("#registerForm").hide();    
        });  
    </script> -->
    <div id="background">
        <div id="loginContainer">
            <br>
            <div id="inputContainer">

                <form id="loginForm" action="register.php" method="POST">
                    <h2>Log in to your account</h2>
                    <p>
                    <?php $account->getError(Constants::$loginFailed)?>
                        <label for="loginUsername">Username</label>
                        <input type="text" name="loginUsername" id="loginUsername" placeholder="username">
                    </p>

                    <p>
                        <label for="loginPassword">Password</label>
                        <input type="password" name="loginPassword" id="loginPassword" placeholder="password">
                    </p>

                    <button type="submit" name="loginSubmit">Login</button>
                    <p>
                        <div class="hasAccountText">
                            <span id="hideLogin">Don't have an account? Sign Up here</span>
                        </div>
                    </p>
                    
                </form>
            
                <form id="registerForm" action="register.php" method="POST">
                    <h2>Register as a new user</h2>
                    <p>
                        <?php $account->getError(Constants::$usernameLength)?>
                        <?php $account->getError(Constants::$usernameTaken)?>
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="username" value="<?php getValue('username')?>" required>
                    </p>
                    <p>
                        <?php $account->getError(Constants::$firstNameLength)?>
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" placeholder="first name" value="<?php getValue('firstName')?>" required>
                    </p>

                    <p>                        
                        <?php $account->getError(Constants::$lastNameLength)?>
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" placeholder="last name" value="<?php getValue('lastName')?>" required>
                    </p>            
                    <p>
                        <?php $account->getError(Constants::$emailInvalid)?>
                        <?php $account->getError(Constants::$emailsDoNotMatch)?>
                        <?php $account->getError(Constants::$emailTaken)?>

                        <label for="email1">Email-ID</label>
                        <input type="email" name="email1" id="email1" placeholder="email" value="<?php getValue('email1')?>" required>
                    </p>
                    <p>
                        <label for="email2">Confirm Email</label>
                        <input type="email" name="email2" id="email2" placeholder="email" value="<?php getValue('email2')?>" required>
                    </p>

                    <p>
                        <?php $account->getError(Constants::$passwordLength)?>
                        <?php $account->getError(Constants::$passwordsDoNotMatch)?>
                        <label for="Password1">Password</label>
                        <input type="password" name="Password1" id="Password1" placeholder="password" required>
                    </p>

                    <p>
                        <label for="Password2">Confirm Password</label>
                        <input type="password" name="Password2" id="Password2" placeholder="password" required>
                    </p>

                    <button type="submit" name="registerSubmit">Sign up</button>
                    <p>
                        <div class="hasAccountText">
                            <span id="hideRegister">Already have an account? Log in here</span>
                        </div>
                    </p>
                    
                </form>
                <br>
            </div>
            <!-- <br> -->

            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you'll fall in love in with</li>
                    <li>Create your own playlists</li>
                    <li>Follow artists to keep up to date</li>
                </ul>
            </div>
        
        </div>
        
    </div>
</body>
</html>