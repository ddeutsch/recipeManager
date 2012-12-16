<!-- This is the sign-in page for the website. -->
<?php
    session_start(); // Initiate session data log

    $_SESSION['db_host'] = "dbase.cs.jhu.edu";
    $_SESSION['db_user'] = "415_12_recipe";
    $_SESSION['db_pass'] = "pass";
    $_SESSION['db_name'] = "cs41512_recipe_db";
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Recipe Manager</title>
</head>
<body>
    <img src="../img/logo.png" usemap="#map" class="center"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="index.php" />
    </map>

    <div class="info">
    <?php

    if (array_key_exists('NO_CREDS', $_SESSION))
    {
	if ($_SESSION['NO_CREDS'])
	{
	    echo "<FONT COLOR='#ff0000'> <h4> You need to enter a username and password</h4></FONT>" ;
	    $_SESSION['NO_CREDS'] = false;
	}
    }

    if (array_key_exists('WRONG_CREDS', $_SESSION))
    {
      if ($_SESSION['WRONG_CREDS'])
	{
	    echo "<FONT COLOR='#ff0000'> <h4> Invalid username or password!</h4></FONT>" ;
	    $_SESSION['WRONG_CREDS'] = false;
	}
    }
    ?>
    </div>

    <br/>
    <div class="form">
    <form action="validateUser.php" method="post" class="center">
        Username: <input type="text" name="username" /><br />
        Password: <input type="password" name="password" /><br /><br />
        <input type="submit" value="Log in" />
    </form>

    <p>New User? Click <a href="./newUser.php">here</a></p>
    </div>

</body>
</html>
