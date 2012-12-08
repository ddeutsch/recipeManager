<?php
    session_start();
     include('simple_html_dom.php');
     include('AllRecipesParser.php');

    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    $allRecipesSearchUrl = "http://allrecipes.com/search/default.aspx?wt=";

    $searchTerm = "chicken";

    $html = file_get_html($allRecipesSearchUrl . $searchTerm);

    $allRecipes = new AllRecipesParser;

    // Add Signout button here ???
    foreach($html->find('h3.resultTitle') as $result)
    {
        $result = str_replace("'", "", str_replace(" ", "-", trim($result->plaintext)));
        echo $result . "<br>";
        $allRecipes->parse("http://allrecipes.com/recipe/" . $result);
    }




















      /*
      $html = file_get_html('http://www.myrecipes.com/recipe/italian-chicken-artichokes-10000000635678/'); // TODO : DM

      foreach($html->find('meta name="recipe_name"') as $recipeName) {
        $recipeNameContent = $recipeName->plaintext;
      }

    echo $recipeNameContent

<meta name="recipe_name" content="Roast Chicken with Balsamic Bell Peppers" />

 <li itemprop="ingredient" itemscope itemtype="http://data-vocabulary.org/RecipeIngredient">
                <span itemprop="amount">5/8 teaspoon</span>
                <span itemprop="name"> salt, divided</span>
                <span itemprop="preparation"> </span>
              </li>

 <h3>Preparation</h3>
    <ol itemprop="instructions">
        <li>1. Preheat oven to 450°.</li>
        <li>2. Heat a large skillet over medium-high heat. Combine 1/2 teaspoon salt, fennel seeds, 1/4 teaspoon black pepper, garlic powder, and oregano. Brush chicken with 1 1/2 teaspoons oil; sprinkle spice rub over chicken. Add 1 1/2 teaspoons oil to pan. Add chicken; cook 3 minutes or until browned. Turn chicken over; cook 1 minute. Arrange chicken in an 11 x 7–inch baking dish coated with cooking spray. Bake at 450° for 10 minutes or until done.</li>
        <li>3. Heat remaining olive oil over medium-high heat. Add bell peppers, shallots, and rosemary; sauté 3 minutes. Stir in broth, scraping pan to loosen browned bits. Reduce heat; simmer 5 minutes. Increase heat to medium-high. Stir in vinegar, 1/4 teaspoon salt, and 1/4 teaspoon pepper; cook 3 minutes, stirring frequently. Serve bell pepper mixture over chicken.</li>
    </ol>
*/
?>
