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
        try
        {
            // trouble here.. don't know what's going on. Sometimes no results show up!
            $result = str_replace("'", "", str_replace(" ", "-", trim($result->plaintext)));
            $result = preg_replace("-+", "-", $result);

            $newResult = "";
            for ($i = 0; $i < strlen($result); $i++)
            {
                if (($result[$i] >= 'a' && $result[$i] <= 'z') || ($result[$i] >= 'A' && $result[$i] <= 'Z'))
                    $newResult = $newResult . $result[$i];
                if ($result[$i] == '-')
                    $newResult = $newResult . '-';
            }
            $result = $newResult;   
            
            $allRecipes->parse("http://allrecipes.com/recipe/" . $result);
            
            $count = $count + 1;
            if ($count >= 5)
                break;    
        }
        catch (Exception $e)
        {
            echo "Got an exception<br>";
            // do nothing
        }
    }
    
    echo "<a href='displayRecipeResults.php'>click here</a>";
    header('Location: displayRecipeResults.php');
?>