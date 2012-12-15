<?php
  session_start();

  // Testing
  //include ("myRecipesParser.php");
  //include("simple_html_dom.php");
  //
  //// $search_term = "baby back ribs"; // good
  //$search_term = "chocolate blah"; // bad
  //
  //$myRecipesSearchObj = new myRecipesSearch;
  //$myRecipesSearchObj->webSearch($search_term);


      class myRecipesSearch
      {
        function webSearch($search_term)
        {
          $search_term = str_replace(" ","+",$search_term);
          $base_url = "http://search.myrecipes.com/search.html?Ntt=".$search_term."&x=0&y=0";

          $html = file_get_html($base_url);

          $recipe_urls = array(); //  Array to hold recipe urls
          $span_array = array(); // Array to hold the type of urls received i.e Recipe, Article etc
          $recipe_names = array(); // Array to hold the names of the recipes

          // Get spans containing info of whether tag is a collection or a recipe
          foreach($html->find('h4 span') as $h4as)
          {
            array_push($span_array, $h4as->innertext);
            //echo $h4as->innertext . "<br/>";
          }

          // If we get here & we have no span tags inside h4 tags then we have a bad search
          if (sizeof($span_array) == 0)
          {
            $_SESSION['BAD_SEARCH'] = true;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
          }

          // Get recipe urls & names
          foreach($html->find('h4 a') as $h4aHref)
          {
            array_push($recipe_urls, $h4aHref->href);
            //echo $h4aHref->href . "<br/>";

            array_push($recipe_names, trim($h4aHref->plaintext));
            //echo $h4aHref->plaintext . "<br/>";

          }

          // Get only the urls & recipes names that are for recipes & not articles/collections etc
          $final_recipe_urls = array();
          $final_recipe_names = array();

          $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
          if (!$conn)
          {
              echo "Error connecting to the database in " . __FILE__;
              exit();
          }

          mysql_select_db($_SESSION['db_name'], $conn);

          $recipe_names = array_unique($recipe_names); // Make array unique

          foreach(array_keys($recipe_names) as $idx)
          {

        //  for ($idx = 0; $idx < sizeof($recipe_urls); $idx++)
        //  {
            $query = "SELECT COUNT(R.RecipeName) AS cnt
                      FROM Recipes R
                      WHERE RecipeName = '$recipe_names[$idx]'
                      GROUP BY RecipeName";

            $result = mysql_query($query);
            $row = mysql_fetch_array($result);

            if ($span_array[$idx] == "Recipe" && $row['cnt'] != 1)
            {
              //echo "I will add here! <br/>";
              array_push($final_recipe_urls, $recipe_urls[$idx]);
              array_push($final_recipe_names, $recipe_names[$idx]);
              //echo "Name =" . $recipe_names[$idx] . " ====> Url = " .$recipe_urls[$idx]."<br/>";
            }
            // echo $span_array[$idx]."<br/>";
          }

          //echo "*****************************************<br/>";

          for ($idx = 0; $idx < sizeof($final_recipe_urls); $idx++)
          {
            //echo "Idx = ".$idx. "URL = " . $final_recipe_urls[$idx] . "<br/>";
            $parseObj = new MyRecipesParser;
            $var = $parseObj->parseSearch($final_recipe_urls[$idx], $final_recipe_names[$idx]);
          }

         // echo "Im here!";
         // return $var;
        }
      }

    ?>