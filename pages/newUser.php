﻿<!-- This is the page which the user will use in order to create an account on the website. -->

<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>New User</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
   <img class="center" src="../img/logo.png" usemap="#map"/>

    <map name="map">
        <area shape="rect" coords="0,0,235,49" alt="Home" href="index.php" />
    </map>
    <br>
    <div class="form">
      <?php

      if (array_key_exists('DUPLICATE_USERNAME', $_SESSION))
      {
	if ($_SESSION['DUPLICATE_USERNAME'])
	  {
	    echo "<FONT COLOR='#ff0000'> <h3> Sorry, that username is already in use!</h3></FONT>" ;
	    $_SESSION['DUPLICATE_USERNAME'] = false;
	  }
      }
      ?>

      <!-- The log in form -->
      <form action="createUser.php" method="post">
	  First Name: <input type="text" name="fname" /><br />
	  Last Name: <input type="text" name="lname" /><br />
	  Username: <input type="text" name="username" /><br />
	  Password: <input type="password" name="password" /><br /><br />
	  <input type="submit" value="Create Account"/>
      </form>
    </div>
</body>
</html>
