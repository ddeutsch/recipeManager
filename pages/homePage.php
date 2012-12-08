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
    <title>Homepage</title>
    <script type="text/javascript">
      // Function to add a spinner during upload & processing
      function showSpinner()
      {
        document.getElementById('loadingImage').style.visibility='visible';
      }
    </script>
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
    <?

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

	$query = "SELECT U.FName, U.LName
		  FROM Users U
		  WHERE U.Username = '".$_SESSION['username']."'";

	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	printf("<h3>Welcome, %s %s!</h3>", $row['FName'], $row['LName']);
    ?>

    <!--<form action="search2.php" method="post">-->
    <form action="combinedSearch.php" method="post">
        Search for recipes: <input type="text" name="recipeName" /> <br />
        <input type="submit" value="Search" onclick="showSpinner();" />
    </form>
    <br />

    <form action="cabinetSearch.php" method="post">
        Search for recipes by your cabinet ingredients: <br />
        <input type="submit" value="Search" onclick="showSpinner();"/>
    </form>

    <p>Edit the ingredients in your cabinet <a href="cabinet.php">here</a></p>

    <p>See all of the recipes in the database <a href="displayAllRecipes.php">here</a></p>

    </div>

    <div style="position:absolute; left:153px; top: 100px;"> <img id="loadingImage"
        src="http://i1061.photobucket.com/albums/t473/dmhembe/MR-connectome/loading_zpsac6e6d22.gif"
        border="0" alt="loading" style="visibility:hidden;opacity:0.5"/> </div>

    <a href="allRecipesParser.php">AllRecipesParser</a> </br>
    <a href="parser.php">MyRecipesParser</a> </br>

    <a href="crawler.php">Perform search for "Chicken"</a>
</body>
</html>
