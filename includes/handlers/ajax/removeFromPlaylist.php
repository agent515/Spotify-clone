<?php 
include("../../config.php");

if(isset($_POST['songId']) && isset($_POST['playlistId'])){
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $query = mysqli_query($conn, "DELETE FROM playlistSongs WHERE songId = '$songId' AND playlistId = '$playlistId'");
}
else{
    echo "PlaylistId or songId was not passed into the addToPlaylist.php";
}

?>