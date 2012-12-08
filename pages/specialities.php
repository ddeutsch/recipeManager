<?php
  session_start();

  // All the specialities
  $allIng = array('beef', 'chicken','cheese','chocolate','egg','fish', 'fruit'
          ,'rice','sausage','seafood','shrimp', 'soy','vegetable','pork','turkey');

?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Specialities</title>

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

        <select>
        <?php
        foreach($allIng as $ing)
        {
        printf("<option value=%s>%s</option>",$ing,$ing);
        }
        ?>
        </select>
      </div>

    </body>
  </head>
</html>


<?php
  // include ("myRecipesParser.php");

  class myRecipesSearch
  {
    function webSearch($search_term)
    {
      // $search_term = $_SESSION['searchTerm'];

      $search_array = preg_split("[\s]", $search_term); // Split search term by word
      $allIng = array('beef', 'chicken','cheese','chocolate','egg','fish', 'fruit'
          ,'rice','sausage','seafood','shrimp', 'soy','vegetable','pork','turkey');

      foreach($search_array as $s)
      {
        if ( in_array($s, $allIng) )
        {
          $search_ingredient = $s;
          break;
        }
      }

      if (!isset($search_ingredient))
      {
        return;
      }

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
      //echo "Add recipes & Images to the DB Done!";
      return $var;
    }
  }
?>