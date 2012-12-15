<!-- This script is responsible for adding an ingredient to the User's cabinet. It should
only be called from cabinet.php because it adds the ingredient, then redirects back to
cabinet.php to give the illusion that a row in the ingredients table was just created. -->

<?php
    session_start();
    include("userStatus.php");

    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
    if (!$conn)
    {
	echo "Error connecting to the database";
	exit();
    }

    mysql_select_db($_SESSION['db_name'], $conn);

    $ingredient = $_POST['ingredient'];

    // perform the INSERT
    $query = "INSERT INTO Cabinet VALUES ('".$_SESSION['username']."','".$ingredient."')";
    mysql_query($query);

    // insert into Ingredients so it appears on the universal ingredient list
    $query = "INSERT INTO Ingredients VALUES (' ', '".$ingredient."', ' ')";
    mysql_query($query);

    echo "<a href=\"cabinet.php\">another redicrect not working</a><br>";
    header('Location: cabinet.php');
?>
