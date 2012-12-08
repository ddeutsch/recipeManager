<?php
  session_start();
  include("userStatus.php");
  checkLoggedIn($_SESSION['username']); // Make sure the user is logged in
  $_SESSION['searchTerm'] = strtolower($_POST['recipeName']);
?>

<html>
  <head>
    <!--<meta http-equiv="refresh" content="1;url=results.php"> -->
  </head>
  <body>
    <?php
      // Search ingredient term

      include ("myRecipesParser.php");
      //include('simple_html_dom.php'); // Cannot include this again if you have already done so

      // $search_ingredient = "beef";
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
        if ($fivestar->href != '#')
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
      }

      for ($idx = 0; $idx < sizeof($recipe_urls); $idx++)
      {

        $parseObj = new MyRecipesParser;
        $var = $parseObj->parse($recipe_urls[$idx], $recipe_images[$idx]);
      }
    echo "Add recipes & Images to the DB Done!";
    ?>

  </body>
</html>