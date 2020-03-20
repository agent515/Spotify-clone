<?php
    
    class Playlist {

        private $conn;
        private $playlistId;
        private $name;
        private $owner;
        private $dateCreated;

        public function __construct($conn, $data){
            
            if(!is_array($data)){
                //id is passed as the data
                $query = mysqli_query($conn, "SELECT * FROM playlists WHERE id = '$data'");
                $data = mysqli_fetch_array($query);
            }
            
            $this->conn = $conn;
            $this->playlistId = $data['id'];
            $this->name = $data['name'];
            $this->owner = $data['owner'];
            $this->dateCreated = $data['dateCreated'];
        }

        public function getId() {
            return $this->playlistId;
        }

        public function getName() {
            return $this->name;
        }

        public function getOwner() {
            return $this->owner;
        }

        public function getNumberOfSongs(){
            $query = mysqli_query($this->conn, "SELECT id FROM playlistSongs WHERE playlistId = '$this->playlistId'");
            return mysqli_num_rows($query);
        }

        public function getSongIds(){
            $query = mysqli_query($this->conn, "SELECT songId FROM playlistSongs WHERE playlistId=$this->playlistId ORDER BY playlistOrder ASC");
            
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['songId']);
            }
            return $array;
        }

        public static function getSelectMenu($conn, $username){
            $query = mysqli_query($conn, "SELECT id, name FROM playlists WHERE owner = '$username'");
            $dropDown =  "<select class='item playlist'>
                            <option value = ''>Add to Playlist</option>";
                        // </select>";
            while($row = mysqli_fetch_array($query)){
                $id = $row['id'];
                $name = $row['name'];

                $dropDown = $dropDown . "<option value = '$id'>$name</option>";    
            }
            $dropDown = $dropDown . "</select>";

            return $dropDown;
        }
            
    }

?>