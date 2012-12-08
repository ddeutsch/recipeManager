<?php
  session_start();

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