<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Recipe Manager</title>
</head>
<body>
    <img src="img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>

    <?
	$db_host = 'dbase.cs.jhu.edu:3306';
	$db_user = '415_12_ddeutsc4';
	$db_pass = 'saturnus!Spun-out';
	$db_name = 'cs41512_ddeutsc4_db';

	$conn = mysql_connect($db_host, $db_user, $db_pass);
	if (!$conn)
	{
	    echo "Error connecting to the database";
	    exit();
	}

	mysql_select_db($db_name, $conn);

	$query = "SELECT U.FName, U.LName
		  FROM Users U, CurrentUser CU
		  WHERE U.Username = CU.Username";
	
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	printf("<h3>Welcome, %s %s!", $row['FName'], $row['LName']);
    ?>

    <form action="search.php" method="post">
        Search for recipes: <input type="text" name="recipeName" /> <br />
        <input type="submit" value="Search" />
    </form>
    <br />
    
    <form action="results.html" method="post">
        Search for recipes by your cabinet ingredients: <br />
        <input type="submit" value="Search" />
    </form>

    <p>Edit the ingredients in your cabinet <a href="cabinet.php">here</a></p>

</body>
</html>
