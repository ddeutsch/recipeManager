<?php
    include('simple_html_dom.php');
    include('AllRecipesParser.php');
    session_start();
    $_SESSION['searchTerm'] = $_POST['recipeName'];

    $allRecipesSearchUrl = "http://allrecipes.com/search/default.aspx?wt=";
    
    $searchTerm = $_POST['recipeName'];
    
    $html = file_get_html($allRecipesSearchUrl . $searchTerm);
      
    $allRecipes = new AllRecipesParser;
            
    $count = 0;
    foreach($html->find('h3.resultTitle') as $result)
    {
        $result = str_replace("'", "", str_replace(" ", "-", trim($result->plaintext)));
        //echo $result . "<br>";
        $allRecipes->parse("http://allrecipes.com/recipe/" . $result);
        
        $count = $count + 1;
        if ($count >= 5)
            break;
    }

    echo "<a href='displayRecipeResults.php'>click here</a>";
    //header('Location: displayRecipeResults.php');
?>