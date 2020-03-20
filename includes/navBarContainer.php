<div id="navBarContainer">

    <div class="navBar">
        <div class="logo">
            <span onclick="openPage('index.php')" role='link' tabindex='0'>
                <img src="assets/images/icons/logo.png" alt="logo">
            </span>
        </div>

        <div class="group">
            <div class="navItem">
                    <span onclick="openPage('search.php')" role='link' tabindex='0' class="navItemLink">Search
                    <img class="icon" src="assets/images/icons/search.png" alt="search-logo">
                    </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                    <span onclick="openPage('browse.php')" role='link' tabindex='0' class="navItemLink">Browse</span>
            </div>
            <div class="navItem">
                    <span onclick="openPage('yourMusic.php')" role='link' tabindex='0' class="navItemLink">Your Music</a>
            </div>
            <div class="navItem">
                    <span onclick="openPage('settings.php')" role='link' tabindex='0' class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName() ?></a>
            </div>

        </div>

    </div>

</div>