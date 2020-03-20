<?php 
include("../../config.php");

if(!isset($_POST['username'])){
    echo "username is not set";
    exit();
}
if(isset($_POST["oldPassword"]) || isset($_POST["newPassword1"]) || isset($_POST["newPassword2"])){
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];
    $username = $_POST['username'];

    if($oldPassword == "" || $newPassword1 == "" || $newPassword2 == ""){
        echo "Passoword fields are empty";
        exit();
    }

    $oldMd5 = md5($oldPassword);
    $oldPasswordCheck = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");
    if(mysqli_num_rows($oldPasswordCheck) != 1){
        echo "Password is incorrect";
        exit();
    }

    if($newPassword1 != $newPassword2){
        echo "New Password and Confirm Password do not match";
        exit();
    }

    if(strlen($newPassword1) < 8 || strlen($newPassword1) >30){
        echo "Password's length must be between 8 and 30 characters";
        exit();
    }

    $newMd5 = md5($newPassword1);
    $query = mysqli_query($conn, "UPDATE users SET password = '$newMd5' WHERE username = '$username'");

    echo "Password updated successfully";
}
else{
    echo "oldPassowrd, newPassword1 or newPassword2 is not set";
}


?>