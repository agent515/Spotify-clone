<?php
    include("../../config.php");

    if(isset($_POST['songId'])){
        $songId = $_POST['songId'];
        $songQuery = mysqli_query($conn, "SELECT * FROM songs WHERE id = $songId");
        $result = mysqli_fetch_array($songQuery);
        
        $songJSON = json_encode($result);
        echo $songJSON;
    }
?>