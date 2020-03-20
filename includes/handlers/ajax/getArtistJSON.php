<?php
    include("../../config.php");

    if(isset($_POST['artistId'])){
        $artistId = $_POST['artistId'];
        $query = mysqli_query($conn, "SELECT * FROM artists WHERE id = $artistId");
        $result =mysqli_fetch_array($query);
        
        $songJSON = json_encode($result);
        echo $songJSON;
    }
?>