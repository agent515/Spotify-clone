<?php 
include("includes/includedFiles.php");
?>

<div class="yourMusicHeader">
    <h2>Your Music</h2>
    <div class="playlistButton">
        <button class="button green" onclick="createPlaylist()">Create Playlist</button>
    </div>
    <div class="errorMessage"></div>
</div>



<div id="gridViewContainer" class="borderBottom">
    <h4>Playlists</h4>

    <?php
        $username = $userLoggedIn->getUsername(); 
        $playlistQuery = mysqli_query($conn, "SELECT * FROM playlists WHERE owner = '$username'");
        
        while($row = mysqli_fetch_array($playlistQuery)){

            $playlist = new Playlist($conn, $row);

            echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>"
                    . "<div class='playlistImage'><img src='assets/images/icons/playlist.png'></div>"
                    . "<div class='gridViewInfo'>"
                        . $playlist->getName() .            
                        "</div>" .
                    "</div>";
        }
    ?>
    </div>

</div>