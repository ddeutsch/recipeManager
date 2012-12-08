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
        <title>Search Results</title>
    </head>
    <!-- Sign out button -->
    <form action="signOut.php" method="post" style="position: absolute;
            top:10px; right:40px; width:100px; height:25px">
    <input type="submit" value="Sign Out"/>
    </form>

    <img class="center" src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>

    <body>

	<h3>Search Results:</h3>

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

	    $query = "SELECT R.RecipeName
		      FROM Recipes R
		      WHERE R.RecipeName LIKE '%".$_SESSION['searchTerm']."%'";

	    $result = mysql_query($query);

	    printf("<form action=\"displayRecipe.php\" method=\"post\">");

	    while ($row = mysql_fetch_array($result))
	    {
		printf("%s <input type=\"radio\" name=\"recipeName\" value=\"%s\" /><br />", $row['RecipeName'], $row['RecipeName']);
	    }

	    printf("<input type=\"submit\" value=\"See Recipe\" /></form>");
	    printf("<br />");

	    echo "</table>";
	?>
    </body>
</html>