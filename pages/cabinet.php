<!-- This file displays the ingredients that a user has in their cabinet. -->

<?php
    session_start();
    include("userStatus.php");

    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Recipe Manager</title>
</head>
<body>
    <!-- Sign out button -->
    <form action="signOut.php" method="post" style="position: absolute;
            top:10px; right:40px; width:100px; height:25px">
    <input type="submit" value="Sign Out"/>
    </form>

    <img class="center" src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>

    <div class="form">
    <h1>Your cabinet:</h1>

    <?php

	$conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
	if (!$conn)
	{
	    echo "Error connecting to the database";
	    exit();
	}

	mysql_select_db($_SESSION['db_name'], $conn);

	// Get all of the ingredients in the cabinet.
	$query = "SELECT C.Ingredient
		  FROM Cabinet C
		  WHERE C.Username = '".$_SESSION['username']."'";

	// display the results in a table format
	printf("<table border=\"1\" align=\"center\">");
	printf("<tr><th>Ingredient</th></tr>");

	$result = mysql_query($query);

	while ($row = mysql_fetch_array($result))
	{
	    printf("<tr><td>%s</td></tr>", $row['Ingredient']);
	}

	echo "</table>";
    ?>

    <br>
    <form action="addIngredient.php" method="post">
	New Ingredient: <input type="text" name="ingredient" /><br />
	<input type="submit" value="Add"/>
    </form>

    <form action="addIngredient.php" method="post">
	Add Ingredient from database: </br>
	<select name="ingredient">
	<?php
            $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
            if (!$conn)
            {
                echo "Error connecting to the database in " . __FILE__;
                exit();
            }
            mysql_select_db($_SESSION['db_name'], $conn);

	    $query = "SELECT DISTINCT Ingredient
		      FROM Ingredients
		      ORDER BY Ingredient";

	    $result = mysql_query($query);

	    while ($row = mysql_fetch_array($result))
	    {
		printf("<option value=\"%s\">%s</option>", $row['Ingredient'], $row['Ingredient']);
	    }
	?>
	</select>
	<input type="submit" value="Add"/>
    </form>

    <form action="removeIngredient.php" method="post">
	Remove Ingredient:<br>
	<select name="ingredient" /><br/>
	<?php

            $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
            if (!$conn)
            {
                echo "Error connecting to the database in " . __FILE__;
                exit();
            }
            mysql_select_db($_SESSION['db_name'], $conn);

	    $query = "SELECT C.Ingredient
		    FROM Cabinet C
		      WHERE C.Username = '".$_SESSION['username'] ."';";

	    $result = mysql_query($query);

	    while ($row = mysql_fetch_array($result))
	    {
		printf("<option value=\"%s\">%s</option>", $row['Ingredient'], $row['Ingredient']);
	    }
	?>
	<input type="submit" value="Delete"/>
    </form>

    </div>

</body>
</html>
