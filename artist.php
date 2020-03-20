<?php 
include("includes/includedFiles.php");

if(isset($_GET['id'])){
    $artistId = $_GET['id'];
}
else{
    header("Location: index.php");
}

$artist = new Artist($conn, $artistId);
?>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
            <div class="headerButtons">
                <button class="button green">PLAY</button>            
            </div>
        </div>
    </div>
</div>

<div class="tracklistContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">    
        <div class="trackkistRow">
            <?php
                $songIds = $artist->getSongIds();
                
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

<div id="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQuery = mysqli_query($conn, "SELECT * FROM ALBUMS WHERE artist = $artistId");
        
        while($row = mysqli_fetch_array($albumQuery)){
            // echo $row['title'] . "<br>";
            echo "<div class='gridViewItem'>"
                    . "<span onclick='openPage(\"album.php?id=". $row['id'] ."\")' role='link' tabindex='0'>" 
                        . "<img src=" . $row['artworkPath'] .">".
                            "<div class='gridViewInfo'>"
                            . $row['title']  .            
                            "</div>" . 
                        "</span>" .
                    "</div>";
        }
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getSelectMenu($conn, $userLoggedIn->getUsername()); ?>
</nav>