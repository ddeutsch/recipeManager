<?php
    session_start();
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Recipe Manager</title>
</head>
<body>
    <img src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>
    
    <h3>Search Results:</h3>
	    
	<?php
	    $db_host = 'localhost:8888';
	    $db_user = 'cs41512_recman';
	    $db_pass = 'pass';
	    $db_name = 'cs41512_recipe_db';
    
            $mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
            
            if (mysqli_connect_errno())
              printf("Connect failed: %s<br>", mysqli_connect_errno());
              
            if ($mysqli->multi_query("CALL FindCabinetRecipes('".$_SESSION['username']."');"))
            {
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