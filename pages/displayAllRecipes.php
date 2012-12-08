<?php
    session_start();

    $_SESSION['searchTerm'] = '%';
    header('Location: displayRecipeResults.php');
?>