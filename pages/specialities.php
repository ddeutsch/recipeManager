<?php
  session_start();
  include("userStatus.php");
  checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

  // All the specialities
  $allIng = array('beef', 'chicken','cheese','chocolate','egg','fish', 'fruit'
          ,'rice','sausage','seafood','shrimp', 'soy','vegetable','pork','turkey');

?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
      <script type="text/javascript">
      // Function to add a spinner during upload & processing
      function showSpinner()
      {
        document.getElementById('loadingImage').style.visibility='visible';
      }
    </script>

    <title>Specialities</title>
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
      <h2> Select a speciality recipe to prepare </h2>

        <form method="post" action=myRecipesSpecials.php>
          <select name="ingredient">
          <?php
          foreach($allIng as $ing)
            {
              printf("<option value=%s>%s</option>",$ing,$ing);
            }
          ?>
          <input type="submit" value="Search Specialty Recipe" onclick="showSpinner();"/>
        </select>
        </form>
      </div>
      <div style="position:absolute; left:400px; top: 100px;"> <img id="loadingImage"
        src="http://i1061.photobucket.com/albums/t473/dmhembe/MR-connectome/loading_zpsac6e6d22.gif"
        border="0" alt="loading" style="visibility:hidden;opacity:0.5"/> </div>
    </body>
</html>