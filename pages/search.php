<?php
  session_start();
  $_SESSION['searchTerm'] = $_POST['recipeName'];
?>

<html>
  <head>
    <!--<meta http-equiv="refresh" content="1;url=results.php"> -->
  </head>
  <body>
    <!--
    <p>I was thinking that this php script could do the searching. Then it would redirect to displayRecipeResults.php which would
       then display the results that are "like" the search term. I've added this link below to simulate doing the searching. We would
       actually just do a redirect.</p>
    <p>Click <a href="displayRecipeResults.php">here</a> to see the search results.</p>
    -->
    <?php

      // Searching in a cabinet
      /*
      $cabinetIngredients = getUsersCabinet($_SESSION['username']);
      // $cabinetIngredients = array('chicken','broccoli','beef','beets','cheese');
      foreach ($cabinetIngredients as $ci)
      {
        $base_url = "http://www.myrecipes.com/$ci['Ingredient']-recipes/";
        print $base_url."<br/>" ;
      }
      */
      // Search ingredient term

      include ("myRecipesParser.php");
      //include('simple_html_dom.php'); // Cannot include this again if you have already done so

      $search_ingredient = "beef";
      // $allIng = array('beef', 'chicken','cheese','chocolate','egg','fish', 'fruit'
      // 'rice','sausage','seafood','shrimp', 'soy','vegetable','pork','turkey')

      $search_ingredient = $_SESSION['searchTerm'];

      $base_url = "http://www.myrecipes.com/$search_ingredient-recipes/";

      $html = file_get_html($base_url);
      $recipe_urls = array(); //  Array to hold recipe urls
      $recipe_images = array(); // Array to hold recipe Images

      // Get recipe urls
      foreach($html->find('.horizTout div.img a') as $fivestar)
      {
        array_push($recipe_urls,$fivestar->href);
        // echo "Ingredient url = ". $fivestar->href."<br/>";

         // Get recipe image urls
        $fivestarHtml = str_get_html($fivestar);

        foreach ($fivestarHtml->find('img') as $imgs)
        {
          array_push($recipe_images, $imgs->src);
          // echo "Image url = ". $imgs->src."<br/><br/>";
        }
      }

      for ($idx = 0; $idx < sizeof($recipe_urls); $idx++)
      {
        $parseObj = new MyRecipesParser;
        $var = $parseObj->parse($recipe_urls[$idx], $recipe_images[$idx]);
        echo "Ingredient url = ". $var."<br/><br/><br/>";
      }

      //echo "<a href='displayRecipeResults.php'>click here</a>";
      //header('Location: displayRecipeResults.php');

      /**
       *Untested
       *Get a users cabinet
       *@param string the username whose cabinet we want
       *@return array the food items in a users cabinet
       */
      function getUsersCabinet($username)
      {
        if ( !isset($user))
        {
          $user = $_SESSION['username'];
        }

        $db_host = 'localhost:8888';
        $db_user = 'cs41512_recman';
        $db_pass = 'pass';
        $db_name = 'cs41512_recipe_db';

        $conn = mysql_connect($db_host, $db_user, $db_pass);
        if (!$conn)
        {
            echo "Error connecting to the database in " .
                __FILE__ . "getUsersCabinet";
            exit();
        }

        mysql_select_db($db_name, $conn);

        $query = "SELECT c.Ingredient FROM Cabinet c WHERE
                c.Username = '" .$user ."'";
        $result = mysql_query($query);
	return mysql_fetch_array($result); // Returns the users cabinet
      }

    ?>

  </body>
</html>