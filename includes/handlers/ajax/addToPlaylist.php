<?php 
include("../../config.php");

if(isset($_POST['songId']) && isset($_POST['playlistId'])){
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $playlistOrderQuery = mysqli_query($conn, "SELECT MAX(playlistOrder) + 1 as playlistMaxOrder FROM playlistSongs WHERE playlistId = '$playlistId'");
    $data = mysqli_fetch_array($playlistOrderQuery);
    $order = $data['playlistMaxOrder'];

    $query = mysqli_query($conn, "INSERT INTO playlistSongs VALUES('', '$songId', '$playlistId', '$order')");
}
else{
    echo "PlaylistId or songId was not passed into the addToPlaylist.php";
}

?>