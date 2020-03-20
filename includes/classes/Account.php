<?php
    
    class Account {

        private $conn;
        private $errorArray;

        public function __construct($conn){
            $this->conn = $conn;
            $this->errorArray = array();
        }

        public function register($un, $fn, $ln, $em1, $em2, $pw1, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em1, $em2);
            $this->validatePasswords($pw1, $pw2);
            
            if(empty($this->errorArray)){
                return $this->insertInput($un, $fn, $ln, $em1, $pw1);
            }
            else{
                return False;
            }

        }

        public function getError($error){
            if(in_array($error, $this->errorArray)){
                echo "<span class='error-message'>$error</span>";
            }
        }

        public function login($un, $pw){
            $pw = md5($pw);
            $query = mysqli_query($this->conn, "SELECT * FROM users where username = '$un' AND password = '$pw'");
            if(mysqli_num_rows($query) == 1){
                return True;
            }
            else {
                array_push($this->errorArray, Constants::$loginFailed);
                return False;
            }
        }

        private function insertInput($un, $fn, $ln, $em, $pw){
            $encryptedPw = md5($pw);
            $date = date('Y-m-d');
            $profilePic = "includes/assets/images/profile-pics/"; // includes/assets/images/profile-pics

            // INSERT INTO users ('id', 'username', 'firstName', 'lastName', 'email', 'password', 'dateTime', 'profilePic') VALUES('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')
            echo "INSERT INTO users VALUES('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')";
            $result = mysqli_query($this->conn, "INSERT INTO users VALUES('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
        
            return $result;
        }

        private function validateUsername($un){
            if(strlen($un) < 5 || strlen($un) > 25){
                array_push($this->errorArray, Constants::$usernameLength);
                return;
            }

            //TODO: CHECK IF USERNAME ALREADY EXISTS
            // echo "SELECT * FROM users WHERE username = '$un'";
            $query = mysqli_query($this->conn, "SELECT * FROM users WHERE username = '$un'");
            if(mysqli_num_rows($query) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }

        }

        private function validateFirstName($fn){
            if(strlen($fn) < 2 || strlen($fn) > 25){
                array_push($this->errorArray, Constants::$firstNameLength);
                return;
            }
        }

        private function validateLastName($ln){
            if(strlen($ln) < 2 || strlen($ln) > 25){
                array_push($this->errorArray, Constants::$lastNameLength);
                return;
            }
        }

        private function validateEmails($em1, $em2){
            if($em1 != $em2){
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return ;
            }
            if(!filter_var($em1, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }
            //TODO: CHECK IF EMAIL ALREADY EXISTS
            $query = mysqli_query($this->conn, "SELECT * FROM users WHERE email = '$em1'");
            if(mysqli_num_rows($query) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }

        private function validatePasswords($pw1, $pw2){
            if($pw1 != $pw2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }

            //Check if the password contains only alphabets and numbers..
            // if(preg_match('/[^A-Za-z0-9]/', $pw1)){
            //     array_push(this->errorArray, "Passwords can only contain alphabets and numbers")
            //     return;
            // }

            if(strlen($pw1) < 8 || strlen($pw1) > 30){
                array_push($this->errorArray, Constants::$passwordLength);
                return;
            }
        }
            
    }

?>