<?php
  session_start();
  include ("myRecipesParser.php");
  include("simple_html_dom.php");
  $search_ingredient = $_POST["ingredient"];
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Specialities Results</title>
    </head>

    <body>
      <h1> <?php echo ucfirst($_POST["ingredient"]); ?> Speciality Meals</h1>
      <?php
        webSearch($search_ingredient);
      ?>

    </body>
</html>



<?php
function webSearch($search_ingredient)
  {
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
      $var = $parseObj->parse($recipe_urls[$idx], $recipe_images[$idx],true);
    }
    //echo "Add recipes & Images to the DB Done!";
    return $var;
  }

?>