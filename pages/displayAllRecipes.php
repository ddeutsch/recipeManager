<?php
    session_start();
    include("userStatus.php");
    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    $_SESSION['searchTerm'] = '%';
    header('Location: displayRecipeResults.php');
?>