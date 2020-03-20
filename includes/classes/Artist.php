<?php
    
    class Artist {

        private $conn;
        private $artistId;
        private $name;

        public function __construct($conn, $id){
            $this->conn = $conn;
            $this->artistId = $id;

            $artistQuery = mysqli_query($this->conn, "SELECT name FROM artists WHERE id = $this->artistId");
            $artistName = mysqli_fetch_array($artistQuery);
            $this->name = $artistName['name'];
        }

        public function getId() {
            return $this->artistId;
        }

        public function getName() {
            return $this->name;
        }

        public function getSongIds() {
            $query = mysqli_query($this->conn, "SELECT * FROM songs WHERE artist=$this->artistId ORDER BY plays DESC");
            
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['id']);
            }
            return $array;
        }
            
    }

?>