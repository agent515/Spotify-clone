<?php
    
    class Song {

        private $conn;
        private $songId;
        private $albumId;
        private $title;
        private $artistId;
        private $path;
        private $duration;
        private $genre;
        private $mysqliData;

        public function __construct($conn, $id){
            $this->conn = $conn;
            $this->songId = $id;

            $query = mysqli_query($this->conn, "SELECT * FROM songs WHERE id = $this->songId");
            $this->mysqliData = mysqli_fetch_array($query);
            $this->title = $this->mysqliData['title'];
            $this->albumId = $this->mysqliData['album'];
            $this->artistId = $this->mysqliData['artist'];
            $this->genre = $this->mysqliData['genre'];
            $this->duration = $this->mysqliData['duration'];
            $this->path = $this->mysqliData['path'];
        }
        
        public function getId(){
            return $this->songId;
        }
        
        public function getTitle(){
            return $this->title;
        }

        public function getArtist(){
            return new Artist($this->conn, $this->artistId);
        }

        public function getAlbum(){
            return new Album($this->conn, $this->albumId);
        }
         
        public function getGenre(){
            return $this->genre;
        }
         
        public function gerPath(){
            return $this->path;
        }

        public function getDuration(){
            return $this->duration;
        }

        public function getMysqliData(){
            return $this->mysqliData;
        }
    }

?>