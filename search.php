<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])){
    $term = $_GET['term'];
}
else {
    $term = "";
}
?>

<div class="searchContainer">

    <h4>Search for an artist, album or song</h4>
    <input class="searchInput" type="text" placeholder="Start typing.." value="<?php echo $term; ?>" onfocus="this.value = this.value">

</div>

<script>
    $(".searchInput").focus();
    $(".searchInput")[0].setSelectionRange($(".searchInput").val().length, $(".searchInput").val().length);
    $(function(){
        var timer;
        $(".searchContainer .searchInput").keyup(function(){
            clearTimeout(timer);

            timer = setTimeout(() => {
                var val = $(".searchContainer .searchInput").val();
                openPage("search.php?term=" + val);
                // console.log(val);
            }, 500);
        });
    });
</script>
<?php
    if($term == ""){
        exit();
    }
?>
<div class="tracklistContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">    
        <div class="trackkistRow">
            <?php
                $searchQuery = mysqli_query($conn, "SELECT id FROM songs WHERE title LIKE '$term%'");
                if(mysqli_num_rows($searchQuery) == 0){
                    echo "<span class='noResult'>No songs matched the search " . $term . "</span>";
                }
                
                $songIds = array();
                while($row = mysqli_fetch_array($searchQuery)){
                    array_push($songIds, $row['id']);
                }
                
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

<div class="artistSearchContainer borderBottom">
    <h2>ARTISTS</h2>
    <?php 
    
    $artistSearchQuery = mysqli_query($conn, "SELECT * FROM artists WHERE name LIKE '$term%'");
    if(mysqli_num_rows($artistSearchQuery) == 0){
        echo "<span class='noResult'>No artists matched the search " . $term . "</span>";
    }
    
    while($row = mysqli_fetch_array($artistSearchQuery)){
        $artist = new Artist($conn, $row['id']);
        echo "<div class='artistRow'>
                <span class='artistName' role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artist->getId() . "\")'>" . $artist->getName() . "</span>
            </div>
            ";
    }
    ?>
</div>

<div id="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQuery = mysqli_query($conn, "SELECT * FROM ALBUMS WHERE title LIKE '$term%'");
        if(mysqli_num_rows($albumQuery) == 0){
            echo "<span class='noResult'>No albums matched the search " . $term . "</span>";
        }
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