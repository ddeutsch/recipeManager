<!-- This script is responsible for adding an ingredient to the User's cabinet. It should
only be called from cabinet.php because it adds the ingredient, then redirects back to
cabinet.php to give the illusion that a row in the ingredients table was just created. -->

<?php
    session_start();
    include("userStatus.php");

    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    $db_host = 'localhost:8888';
    $db_user = 'cs41512_recman';
    $db_pass = 'pass';
    $db_name = 'cs41512_recipe_db';

    $conn = mysql_connect($db_host, $db_user, $db_pass);
    if (!$conn)
    {
	echo "Error connecting to the database";
	exit();
    }

    mysql_select_db($db_name, $conn);

    $ingredient = $_POST['ingredient'];

    // perform the INSERT
    $query = "INSERT INTO Cabinet VALUES ('".$_SESSION['username']."','".$ingredient."')";
    mysql_query($query);
    header('Location: cabinet.php');
?>
