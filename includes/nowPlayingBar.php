<?php
$playlist = array();
$playlistQuery = mysqli_query($conn, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
while($row = mysqli_fetch_array($playlistQuery)){
    array_push($playlist, $row['id']);
}
$resultArray = json_encode($playlist);
?>

<script>
    
    $(document).ready(function(){
        var newPlaylist = <?php echo $resultArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeBar(audioElement.audio);
        // updateProgressbar(audioElement.audio);

        $("#nowPlayingBar").on("mousedown mousemove touchstart touchmove", function(e){
            e.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e){
            if(mouseDown){
                timeFromOffset(e, this);
            }
        })

        $(".playbackBar .progressBar").mouseup(function(e){
            timeFromOffset(e, this);
        })

        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e){
            if(mouseDown){
                var percentage = (e.offsetX / $(this).width());
                if(percentage >=0 && percentage<=100){
                    audioElement.audio.volume = percentage;
                }
            }
        })

        $(".volumeBar .progressBar").mouseup(function(e){
            var percentage = (e.offsetX / $(this).width());
            if(percentage >=0 && percentage<=100){
                audioElement.audio.volume = percentage;
            }
        })

        $(document).mouseup(function(){
            mouseDown = false;
        })

        function timeFromOffset(mouse, progressBar){
            var percentage = (mouse.offsetX / $(progressBar).width())*100;
            if(percentage >=0 && percentage<=100){
                var seconds = audioElement.audio.duration * percentage / 100;
                audioElement.setTime(seconds);
            }
            
        }

    });

    function shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
    }

    function setTrack(trackId, newPlaylist, play){
        if(newPlaylist != currentPlaylist){
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        if(shuffle){
            currentIndex = shufflePlaylist.indexOf(trackId);
        }
        else{
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        $.post("includes/handlers/ajax/getSongJSON.php", {songId: trackId}, function(data){
            var track = JSON.parse(data);
            audioElement.setTrack(track);
            if(play){
                audioElement.audio.autoplay = true;
            }
            $("#nowPlayingBar .trackName").text(track['title']);
            
            $.post("includes/handlers/ajax/getArtistJSON.php", {artistId: track.artist }, function(data){
                var artist = JSON.parse(data);
                $(".trackInfo .artistName").text(artist.name);
                $(".trackInfo .artistName").attr("onclick", "openPage('artist.php?id="+ artist.id +"')");
            });

            $.post("includes/handlers/ajax/getAlbumJSON.php", {albumId: track.album }, function(data){
                var album = JSON.parse(data);
                $(".albumLink .albumArtwork").attr("src", album.artworkPath);
                $(".albumLink .albumArtwork").attr("onclick", "openPage('album.php?id=" + album.id + "')");
                $("#nowPlayingBar .trackName").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            });
        });
        
        if(play){
            playSong();
        }
    }

    function playSong(){
        if(audioElement.audio.currentTime == 0.0){
            $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.id});
        }
        audioElement.play();
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
    }

    function pauseSong(){
        audioElement.pause();
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
    }

    function prevSong(){
        if(audioElement.audio.currentTime >= 3.0 || currentIndex == 0){
            audioElement.audio.currentTime = 0.0;
        }
        else{
            currentIndex--;
            // shuffle ? setTrack(shufflePlaylist[currentIndex], currentPlaylist, true); : setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function nextSong(){
        // var trackId = (currentIndex + 1) % currentPlaylist.length;
        if(repeat){
            var trackId = currentIndex;
        }
        else{
            if(currentIndex == currentPlaylist.length-1){
                currentIndex = 0;
            }
            else{
                currentIndex++;
            }
        }

        
        trackId = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        pauseSong();
        // console.log(audioElement.audio);
        setTrack(trackId, currentPlaylist, true);
        // console.log(audioElement.audio);
    }
    
    function setRepeat(){
        repeat = !repeat;
        if(repeat){
            $(".controlButton.repeat img").attr("src", "assets/images/icons/repeat-active.png");
        }
        else{
            $(".controlButton.repeat img").attr("src", "assets/images/icons/repeat.png");
        }
    }

    function setMute(){
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);
    
        if(shuffle){
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(shufflePlaylist[currentIndex]);
        }
        else{
            currentIndex = currentPlaylist.indexOf(currentPlaylist[currentIndex]);
        }
    }

</script>

<div id="nowPlayingBar">

    <div id="nowPlayingLeft">

        <div class="content">
            <span class="albumLink">
                <img role="link" tabindex="0" class="albumArtwork" src="data:image/png;base64,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" alt="">
            </span>

            <div class="trackInfo">
                <span class="trackName" role="link" tabindex="0">
                    <span ></span>
                </span>
                <span class="artistName" role="link" tabindex="0">
                    <span ></span>
                </span>
            </div>
        </div>

    </div>

    <div id="nowPlayingCenter">

        <div class="content playerControls">

            <div class="buttons">

                <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
                    <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                </button>

                <button class="controlButton previous" title="Previous" onclick="prevSong()">
                    <img src="assets/images/icons/previous.png" alt="Previous">
                </button>

                <button class="controlButton play" title="Play" onclick="playSong()">
                    <img src="assets/images/icons/play.png" alt="Play">
                </button>

                <button class="controlButton pause" title="Pause" style="display: none" onclick="pauseSong()">
                    <img src="assets/images/icons/pause.png" alt="Pause">
                </button>

                <button class="controlButton next" title="Next" onclick="nextSong()">
                    <img src="assets/images/icons/next.png" alt="Next">
                </button>

                <button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
                    <img src="assets/images/icons/repeat.png" alt="Repeat">
                </button>

            </div>

            <div class="playbackBar">

                <span class="progressTime current">0.00</span>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
                <span class="progressTime remaining">0.00</span>

            </div>

        </div>

    </div>

    <div id="nowPlayingRight">

        <div class="volumeBar">

            <button class="controlButton volume" title="Volume" onclick="setMute()">
                <img src="assets/images/icons/volume.png" alt="Volume">
            </button>

            <div class="progressBar">
                <div class="progressBarBg">
                    <div class="progress"></div>
                </div>
            </div>

        </div>

    </div>

    </div>