<!-- This script just searches the database for every recipe, then redirects to the results page. -->

<?php
    session_start();
    include("userStatus.php");
    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    // the '%' character will match every string
    $_SESSION['searchTerm'] = '%';
    header('Location: displayRecipeResults.php');
?>