<?php
    include("includes/includedFiles.php");
?>
    <h2 id="mainContentH2">You might also like</h2>
    <div id="gridViewContainer">
    <?php 
        $albumQuery = mysqli_query($conn, "SELECT * FROM ALBUMS ORDER BY RAND() LIMIT 10");
        
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
