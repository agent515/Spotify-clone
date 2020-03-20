var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var timer;

var userLoggedIn;

function openPage(url){
    if(timer != null) {
        clearTimeout(timer);
    }
    
    if(url.indexOf("?") == -1){
        url = url + "?";
    }
    
    var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedURL);
    $("body").scrollTop(0);
    history.pushState(null, null, encodedURL);
}

function logout(){
    $.post("includes/handlers/ajax/logout.php", function(){
        location.reload();
    });
}

function createPlaylist () {
    var newPlaylist = prompt("Enter the name of the playlist: ");
    if(newPlaylist == ""){
        $(".errorMessage").html("<span class='noResult'>Playlist name field cannot be empty</span>");
        return;
    }
    $.post("includes/handlers/ajax/createPlaylist.php", {name: newPlaylist, username: userLoggedIn}).done(
        function(error){
            if(error != ""){
                alert(error);
            }
            openPage("yourMusic.php");
        }
    );
}

function deletePlaylist(playlistId){
    var prompt = confirm("Are you sure want to delete this playlist");
    alert(playlistId);
    if(prompt){
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId}).done(
            function(error){
                if(error != ""){
                    alert(error);
                }
                openPage("yourMusic.php");
            }
        );
    }
}

$(document).on("change", "select.playlist", function(){
    var playlistId = $(this).val();
    var songId = $(this).prev('.songId').val();

    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId}).done(
        function(error){
            if(error != ""){
                alert(error);
                return;
            }
            $("select.playlist").val("");
            // openPage('playlist.php?id='+playlistId);
        }
    );
})

function removeFromPlaylist(button, playlistId){
    var songId = $(button).prevAll('.songId').val();
    
    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId}).done(
        function(error){
            if(error != ""){
                alert(error);
                return;
            }
            openPage('playlist.php?id='+playlistId);
        }
    );
}

function updateEmail(emailClass){
    var email = $("."+emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php", {email: email, username: userLoggedIn}, function(response){
            $("#emailUpdate").text(response);
            // $(".container.broderBottom").find("message").text(response);
            console.log(response);
    });
}

function updatePassword(oldPasswordClass, newPassword1Class, newPassword2Class){
    var oldPassword = $("."+oldPasswordClass).val();
    var newPassword1 = $("."+newPassword1Class).val();
    var newPassword2 = $("."+newPassword2Class).val();

    $.post("includes/handlers/ajax/updatePassword.php", 
    {   oldPassword: oldPassword, 
        newPassword1: newPassword1, 
        newPassword2: newPassword2, 
        username: userLoggedIn
    }, function(response){
        $("#passwordUpdate").text(response);
        console.log(response);
});
}

function showOptionsMenu(button){
    var songId = $(button).prevAll('.songId').val();
    $(".optionsMenu").find('.songId').val(songId);

    var scroll = $(window).scrollTop();
    var top = $(button).offset().top;
    top = top-scroll;
    
    var menuWidth = $(".optionsMenu").width();
    var left = $(button).position().left;
    left = left-menuWidth;

    $(".optionsMenu").css({"top": top + "px", "left": left+ "px", "display": "inline"});
}

function hideOptionsMenu(){
    if($(".optionsMenu").css("display") != "none"){
        $(".optionsMenu").css("display", "none");
    }
}

$(window).scroll(function(){
    hideOptionsMenu();
})

$(document).click(function(click){
    var target = $(click.target);
        if(!target.hasClass("options") && !target.hasClass("item")){
            hideOptionsMenu();
        }
});

function formatTime(seconds) {
    var total = Math.round(seconds);
    var minutes = Math.floor(total / 60);
    var remaining_seconds = total - (minutes*60);
    var extraZero = (remaining_seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + remaining_seconds;
}

function updateProgressbar(audio){
    var progress = (audio.currentTime / audio.duration)*100;
    $(".playbackBar .progress").css("width", progress+"%");
}

function updateVolumeBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume+"%");
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function(){
        nextSong();
    })
    
    this.audio.addEventListener("canplay", function(){
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function() {
        var currentTime = formatTime(this.currentTime);
        $(".progressTime.current").text(currentTime);
        
        updateProgressbar(this);
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeBar(this);
    });
    
    this.setTrack = function(song) {
        this.audio.src = song.path;
        this.currentlyPlaying = song;
    };

    this.play = function(){
        this.audio.play();
    };
    
    this.pause = function() {
        this.audio.pause();
    };

    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }
}