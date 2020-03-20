<?php
    
    class Album {

        private $conn;
        private $albumId;
        private $title;
        private $genre;
        private $artistId;
        private $artworkPath;

        public function __construct($conn, $id){
            $this->conn = $conn;
            $this->albumId = $id;

            $query = mysqli_query($this->conn, "SELECT * FROM albums WHERE id = $this->albumId");
            $album = mysqli_fetch_array($query);
            $this->title = $album['title'];
            $this->genre = $album['genre'];
            $this->artistId = $album['artist'];
            $this->artworkPath = $album['artworkPath'];
        }

        public function getArtist() {
            return new Artist($this->conn, $this->artistId);
        }

        public function getTitle() {
            return $this->title;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getArtworkPath() {
            return $this->artworkPath;
        }

        public function getNumberOfSongs() {
            $query = mysqli_query($this->conn, "SELECT * FROM songs WHERE album=$this->albumId");
            return mysqli_num_rows($query);
        }

        public function getSongIds() {
            $query = mysqli_query($this->conn, "SELECT * FROM songs WHERE album=$this->albumId ORDER BY albumOrder ASC");
            
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['id']);
            }
            return $array;
        }

            
    }

?>