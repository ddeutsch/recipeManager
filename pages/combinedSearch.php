<?php
  session_start();
  include("userStatus.php");
  include ("search.php");
  include ("search2.php");
  include ("myRecipesParser.php");
  include("simple_html_dom.php");
  include("AllRecipesParser.php");

  checkLoggedIn($_SESSION['username']); // Make sure the user is logged in
  $_SESSION['searchTerm'] = $_POST['recipeName'];

  // Check if we have the recipe searched for in the DB
  $rowCount = checkDBforRecipe($_SESSION['searchTerm']);

  // Less than 10 recipes? Crawl the web for some more
  if ($rowCount < 10)
  {
    // Run allrecipes search term search
    $allRecipesSearchObj = new allRecipesSearch;
    $findCount = $allRecipesSearchObj->webSearch(allRecipesParseSearchTerm($_SESSION['searchTerm']));

    // Run myrecipes search term search
    // Don't have enough results? Run search term search of different site
    if ($findCount == 0)
    {
      // DON'T work together for some reason ??
      // $myRecipesSearchObj = new myRecipesSearch;
      // $myRecipesSearchObj->webSearch($_SESSION['searchTerm']);
    }
  }
  echo "<a href='displayRecipeResults.php'>click here</a>";

  /**
   * Check if a provided search term matches any recipe name
   * in the DB.
   * @param string The search term entered by a user
   */
  function checkDBforRecipe($searchTerm)
  {

    $db_host = 'localhost:8888';
    $db_user = 'cs41512_recman';
    $db_pass = 'pass';
    $db_name = 'cs41512_recipe_db';

    $conn = mysql_connect($db_host, $db_user, $db_pass);
    if (!$conn)
    {
        echo "Error connecting to the database in homePage.php";
        exit();
    }

    mysql_select_db($db_name, $conn);

    $query = "SELECT SUM(Count) Total
              FROM
              (
                  SELECT COUNT(*) Count
                  FROM Recipes
                  WHERE RecipeName LIKE '%".$searchTerm."%'
                  GROUP BY RecipeName
              ) T1";

    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    return  $row['Total'];
  }

  /**
   * Parse search term appropriately for use in allRecipes search
   *@param string The search term
   */
  function allRecipesParseSearchTerm($searchTerm)
  {
    $newTerm = "";

    for ($i = 0; $i < strlen($searchTerm); $i++)
    {
        if ($searchTerm[$i] == ' ')
            $newTerm = $newTerm . '-';
        else if (($searchTerm[$i] >= 'a' && $searchTerm[$i] <= 'z') || ($searchTerm[$i] >= 'A' && $searchTerm[$i] <= 'Z'))
            $newTerm = $newTerm . $searchTerm[$i];
    }
    $searchTerm = $newTerm;

    return $searchTerm;
  }
?>