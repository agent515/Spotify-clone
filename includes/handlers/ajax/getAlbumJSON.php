<?php
    include("../../config.php");

    if(isset($_POST['albumId'])){
        $albumId = $_POST['albumId'];
        $query = mysqli_query($conn, "SELECT * FROM albums WHERE id = $albumId");
        $result =mysqli_fetch_array($query);
        
        $songJSON = json_encode($result);
        echo $songJSON;
    }
?>