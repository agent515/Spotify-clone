<?php
    include("includes/includedFiles.php");
?>

<div class="entityInfo">
    <div class="centerSection">
        <h2><?php echo $userLoggedIn->getFirstAndLastName(); ?></h2>
        <div class="buttonItems">
            <!-- <button class="button" onclick="openPage('updateDetails')">User Details</button> -->
            <button class="button" id="logoutButton" onclick="logout()">LOGOUT</button>
        </div>
    </div>
    <div class="userDetails">
        <div class="container borderBottom">
            <h3>Email</h2>
            <input type="text" name="email" class="emailID" placeholder="Email-Id" value="<?php echo $userLoggedIn->getEmail(); ?>">
            <span class="message" id="emailUpdate"></span>
            <button class="button" onclick="updateEmail('emailID')">Save</button>
        </div>
        <div class="container">
            <h3>Password</h2>
            <input type="password" name="oldPassword" class="oldPassword" placeholder="Current Password">
            <input type="password" name="newPassword1" class="newPassword1"placeholder="New Password">
            <input type="password" name="newPassword2" class="newPassword2"placeholder="Confirm Password">
            <span class="message" id="passwordUpdate"></span>
            <button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">Save</button>
        </div>
    </div>

</div>