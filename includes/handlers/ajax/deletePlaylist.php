<?php
    include("../../config.php");

    if(isset($_POST['playlistId'])){
        $playlistId = $_POST['playlistId'];
        echo $playlistId;
        $playlistQuery = mysqli_query($conn, "DELETE FROM playlists WHERE id = $playlistId");
        $playlistSongsQuery = mysqli_query($conn, "DELETE FROM playlistSongs WHERE playlistId = $playlistId");    
    }
    else{
        echo "PlaylistID was not passed into the deletePlaylist.php";
    }
?>