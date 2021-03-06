<!-- This script searches the database for any recipe name that contains the search term as a substring,
then displays the results in a form, which allows the user to select them and see the recipe contents. -->

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
	    $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
	    if (!$conn)
	    {
		echo "Error connecting to the database in homePage.php";
		exit();
	    }

	    mysql_select_db($_SESSION['db_name'], $conn);

	    // find all of the recipes which match the searchTerm
	    $query = "SELECT R.RecipeName
		      FROM Recipes R
		      WHERE R.RecipeName LIKE '%".str_replace(" ","%", $_SESSION['searchTerm'])."%'"; // DM - Edit for better regex matching

	    $result = mysql_query($query);

	    // display the results in a form
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