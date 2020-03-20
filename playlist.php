<?php  include("includes/includedFiles.php");


if(isset($_GET['id'])){
    $playlistId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$playlist = new Playlist($conn, $playlistId);
$owner = $playlist->getOwner();


// echo $album->getTitle() . "<br>";
// echo $artist->getName();
?>
    <div class="entityInfo">
        <div class="leftSection">
            <div class="playlistImage">
                <img src="assets/images/icons/playlist.png">
            </div>
        </div>
        <div class="rightSection">
            <h2><?php echo $playlist->getName(); ?></h2>

            <p>By <?php echo $playlist->getOwner(); ?></p>
            <p><?php echo $playlist->getNumberOfSongs() ?> Songs</p>
        
            <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
        </div>
    </div>


    <div class="tracklistContainer">
        <ul class="tracklist">    
            <div class="trackkistRow">
                <?php
                    $songIds = $playlist->getSongIds();
                    
                    $i = 1;
                    foreach($songIds as $songId) {
                        $playlistSong = new Song($conn, $songId);
                        $artistSong =$playlistSong->getArtist();  
                        echo "<div class='tracklistRow'>
                                <div class='trackCount'>
                                    <img class='playImg' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $playlistSong->getId() ."\", tempPlaylist, true)'>
                                    <span class='trackNumber'>" . $i . "</span>
                                </div>
                                <div class='trackInfo'>
                                    <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                                    <span class='trackArtist' role = 'link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistSong->getId() . "\")'>" . $artistSong->getName() . "</span>
                                </div>
                                <div class='trackOptions'>
                                    <input type='hidden' class='songId' value = '". $playlistSong->getId() . "'>
                                    <img class='options' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                </div>
                                <div class='trackDuration'>
                                    <span class='duration'>" . $playlistSong->getDuration() . "</span>
                                </div>
                            </div>";
                    
                        $i = $i + 1;
                    }
                
                ?>

                <script>
                    var tempSongArray = '<?php echo json_encode($songIds);?>';
                    tempPlaylist = JSON.parse(tempSongArray);
                </script>  

            </div>
        </ul>
    </div>

    <nav class="optionsMenu">
        <input type="hidden" class="songId">
        <?php echo Playlist::getSelectMenu($conn, $userLoggedIn->getUsername()); ?>
        <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
    </nav>