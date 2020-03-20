<?php  include("includes/includedFiles.php");


if(isset($_GET['id'])){
    $albumId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$album = new Album($conn, $albumId);
$artist = $album->getArtist();


// echo $album->getTitle() . "<br>";
// echo $artist->getName();
?>
    <div class="entityInfo">
        <div class="leftSection">
            <img src="<?php echo $album->getArtworkPath(); ?>">
        </div>
        <div class="rightSection">
            <h2><?php echo $album->getTitle(); ?></h2>

            <p>By <?php echo $artist->getName(); ?></p>
            <p><?php echo $album->getNumberOfSongs() ?> Songs</p>
        </div>
    </div>


    <div class="tracklistContainer">
        <ul class="tracklist">    
            <div class="trackkistRow">
                <?php
                    $songIds = $album->getSongIds();
                    
                    $i = 1;
                    foreach($songIds as $songId) {
                        $albumSong = new Song($conn, $songId);
                        $artistSong =$albumSong->getArtist();  
                        echo "<div class='tracklistRow'>
                                <div class='trackCount'>
                                    <img class='playImg' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $albumSong->getId() ."\", tempPlaylist, true)'>
                                    <span class='trackNumber'>" . $i . "</span>
                                </div>
                                <div class='trackInfo'>
                                    <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                    <span class='trackArtist' role = 'link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistSong->getId() . "\")'>" . $artistSong->getName() . "</span>
                                </div>
                                <div class='trackOptions'>
                                    <input type='hidden' class='songId' value = '". $albumSong->getId() . "'>
                                    <img class='options' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                </div>
                                <div class='trackDuration'>
                                    <span class='duration'>" . $albumSong->getDuration() . "</span>
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
    </nav>