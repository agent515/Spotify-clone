<?php 
include("../../config.php");

if(!isset($_POST['username'])){
    echo "username is not set";
    exit();
}
if(isset($_POST["email"]) && $_POST["email"] != ""){
    $email = $_POST['email'];
    $username = $_POST['username'];
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "email is not valid";
        exit();
    }

    $emailCheck = mysqli_query($conn, "SELECT email FROM users WHERE username != '$username' AND email = '$email'");
    if(mysqli_num_rows($emailCheck) > 0){
        echo "email is already in use";
        exit();
    }

    $query = mysqli_query($conn, "UPDATE users SET email = '$email' WHERE username = '$username'");
    echo "Email updated successfully!";


}
else{
    echo "You must provide an email";
}


?>