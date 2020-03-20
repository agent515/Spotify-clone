<?php
    
    class User {

        private $conn;
        private $id;
        private $username;
        private $firstName;
        private $lastName;
        private $dateCreated;

        public function __construct($conn, $username){
            $this->conn = $conn;
            $this->username = $username;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getEmail() {
            $query = mysqli_query($this->conn, "SELECT email FROM users WHERE username = '$this->username'");
            $row = mysqli_fetch_array($query);
            return $row['email'];
        }

        public function getFirstAndLastName(){
            $query = mysqli_query($this->conn, "SELECT concat(firstName, ' ', lastName) as name FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }
            
    }

?>