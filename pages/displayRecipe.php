<?php
    session_start();
    include("userStatus.php");
    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
        <title>Recipe</title>
    </head>

    <img class="center" src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>

    <body>
    <!-- Sign out button -->
    <form action="signOut.php" method="post" style="position: absolute;
            top:10px; right:40px; width:100px; height:25px">
    <input type="submit" value="Sign Out"/>
    </form>

    <div class="form">
        <?php
	    $db_host = 'localhost:8888';
	    $db_user = 'cs41512_recman';
	    $db_pass = 'pass';
	    $db_name = 'cs41512_recipe_db';

	    $conn = mysql_connect($db_host, $db_user, $db_pass);
	    if (!$conn)
	    {
		echo "Error connecting to the database in homePage.php";
		exit();
	    }

	    mysql_select_db($db_name, $conn);

            // set the correct recipe here
            $recipe = $_SESSION['searchTerm']; // DM: Fix - Was originally -> $_POST['recipeName'];

            printf("<h2>%s</h2>", ucwords($recipe));

	    // Image
	    $query = "SELECT ImageUrl
		      FROM Images
		      WHERE RecipeName = \"$recipe\"";
	    $result = mysql_query($query);

	    $row = mysql_fetch_array($result);

	    printf("<img src=\"%s\"/>", $row['ImageUrl']);

	    // Recipe information
            $query = "SELECT *
		     FROM Recipes R
		     WHERE R.RecipeName = \"$recipe\"";
            $result = mysql_query($query);

	    $row = mysql_fetch_array($result);

	    printf("<p>Servings: %s</p>", $row['Servings']);
	    printf("</div>");

	    // Ingredient information
	    $query = "SELECT *
		      FROM Ingredients I
		      WHERE I.RecipeName = \"$recipe\"";
	    $result = mysql_query($query);

	    printf("<h2> Ingredients: </h2>");
	    printf("<ul>");
	    while ($row = mysql_fetch_array($result))
	    {
		printf("<li>%s %s</li>", $row['Quantity'], $row['Ingredient']);
	    }
	    printf("</ul>");

	    // Instructions information
	    $query = "SELECT *
		      FROM Instructions I
		      WHERE I.RecipeName = \"$recipe\"";
	    $result = mysql_query($query);
	    $row = mysql_fetch_array($result);

	    printf("<h2>Instructions:</h2>");
	    printf("<p>%s</p>", $row['Instructions']);
        ?>
    </body>
</html>