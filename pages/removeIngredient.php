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

    $query = "DELETE FROM Cabinet WHERE Username = '".$_SESSION['username']."' AND Ingredient ='".$ingredient."'";
    //echo $query;
    mysql_query($query);
    header('Location: cabinet.php');
?>
