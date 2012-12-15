<!-- This script removes an ingredient from the user's cabinet. The name of the ingredient should be
in $_POST['ingredient']. This should only be called from cabinet.php because this script
will redirect back to that page after the ingredient has been removed. -->

<?php
    session_start();
    include("userStatus.php");
    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in
    
    $db_host = 'localhost:8888';
    $db_user = 'cs41512_recman';
    $db_pass = 'pass';
    $db_name = 'cs41512_recipe_db';

    $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
    if (!$conn)
    {
	echo "Error connecting to the database";
	exit();
    }

    mysql_select_db($db_name, $conn);

    $ingredient = $_POST['ingredient'];

    $query = "DELETE FROM Cabinet WHERE Username = '".$_SESSION['username']."' AND Ingredient ='".$ingredient."'";
    mysql_query($query);

    echo "<a href=\"cabinet.php\">another redirect not working</a><br>";
    header('Location: cabinet.php');
?>
