<?php
  session_start();

  // Testing
  //include ("myRecipesParser.php");
  //include("simple_html_dom.php");
  //
  //$search_term = "chocolate cake";
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

          // Get recipe urls & names
          foreach($html->find('h4 a') as $h4aHref)
          {
            array_push($recipe_urls, $h4aHref->href);
            //echo $h4aHref->href . "<br/>";

            array_push($recipe_names, $h4aHref->plaintext);
            //echo $h4aHref->plaintext . "<br/>";

          }

          // Get only the urls & recipes names that are for recipes & not articles/collections etc
          $final_recipe_urls = array();
          $final_recipe_names = array();

          for ($idx = 0; $idx < sizeof($recipe_urls); $idx++)
          {
            if ($span_array[$idx] == "Recipe")
            {
              array_push($final_recipe_urls, $recipe_urls[$idx]);
              array_push($final_recipe_names, $recipe_names[$idx]);
              //echo "Name =" . $recipe_names[$idx] . " ====> Url = " .$recipe_urls[$idx]."<br/>";
            }
          }

         // echo "*****************************************<br/>";

          for ($idx = 0; $idx < sizeof($final_recipe_urls); $idx++)
          {
           // echo "Idx = ".$idx. "URL = " . $final_recipe_urls[$idx] . "<br/>";
            $parseObj = new MyRecipesParser;
            $var = $parseObj->parseSearch($recipe_urls[$idx], $recipe_names[$idx]);
          }

         // echo "Im here!";
         // return $var;
        }
      }

    ?>