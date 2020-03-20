<?php

    function cleanUsername($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    function cleanString($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = ucfirst(strtolower($inputText));
        return $inputText;
    }

    function cleanPassword($inputText){
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    if(isset($_POST['registerSubmit'])){
        $username = cleanUsername($_POST['username']);
        $firstName = cleanString($_POST['firstName']);
        $lastName = cleanString($_POST['lastName']);
        $email1 = $_POST['email1'];
        $email2 = $_POST['email2'];
        $password1 = cleanPassword($_POST['Password1']);
        $password2 = cleanPassword($_POST['Password2']);

        //validate the details using methods in the Account class
        $wasSuccessful = $account->register($username, $firstName, $lastName, $email1, $email2, $password1, $password2);

        if($wasSuccessful){
            header("Location: index.php");
        }
    }

?>