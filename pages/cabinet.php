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

    <h1>Your cabinet:</h1>

    <?
	$db_host = 'dbase.cs.jhu.edu';
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

	$query = "SELECT C.Ingredient 
		  FROM Cabinet C, CurrentUser U 
		  WHERE U.Username = C.Username";

	printf("<table border=\"1\">");
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


</body>
</html>
