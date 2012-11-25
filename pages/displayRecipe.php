<?php
    session_start();
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Recipe</title>
    </head>
    
    <img src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="homePage.php" />
    </map>
    
    <body>
    
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
            $recipe = $_POST['recipeName'];
            
            printf("<h2>%s</h2>", $recipe);

            //$query = "SELECT"
            
            //$result = mysql_query($query);

        ?>
        
    </body>
</html> 