<?php
    session_start();
    $db_host = 'localhost:8888';
    $db_user = 'cs41512_recipe_manager';
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

    $query = "INSERT INTO Cabinet VALUES ('".$_SESSION['username']."','".$ingredient."')";
    mysql_query($query);
    header('Location: cabinet.php');
?>
