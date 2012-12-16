<!-- This script checks to find any recipes that the user can make based on having all
of that recipe's ingredients in their cabinet. -->

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

    <img src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>

    <h3>Search Results:</h3>

	<?php
            $mysqli = new mysqli($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name']);

            if (mysqli_connect_errno())
		printf("Connect failed: %s<br>", mysqli_connect_errno());

		$query = "SELECT COUNT(Ingredient) AS cnt
			FROM Cabinet WHERE
			Username = '" .$_SESSION['username']."'
	    		GROUP BY Username";

		$mysqli->multi_query($query);
		$result = $mysqli->store_result();

		$row = mysql_fetch_array($result);
		$row = $result->fetch_row();

	      if ($row < 1)
	      {
		$_SESSION['CABINET_EMPTY'] = true;
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	      }

            // call MySQL procedure to find the recipes
            if ($mysqli->multi_query("CALL FindCabinetRecipes('".$_SESSION['username']."');"))
            {
              // display the results in a form
              printf("<form action=\"displayRecipe.php\" method=\"post\">");

              if ($result = $mysqli->store_result())
              {
                while ($row = $result->fetch_row())
                  printf("%s <input type=\"radio\" name=\"recipeName\" value=\"%s\" /><br />", $row[0], $row[0]);
              }

              printf("<input type=\"submit\" value=\"See Recipe\" /></form>");
              printf("<br />");
            }
	?>
</body>
</html>