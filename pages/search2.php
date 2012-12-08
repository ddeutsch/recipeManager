<?php
    include('simple_html_dom.php');
    include('AllRecipesParser.php');
    session_start();
    $_SESSION['searchTerm'] = $_POST['recipeName'];

    $allRecipesSearchUrl = "http://allrecipes.com/search/default.aspx?wt=";
    
    $searchTerm = $_POST['recipeName'];
    $newTerm = "";
    
    for ($i = 0; $i < strlen($searchTerm); $i++)
    {
        if ($searchTerm[$i] == ' ')
            $newTerm = $newTerm . '-';
        else if (($searchTerm[$i] >= 'a' && $searchTerm[$i] <= 'z') || ($searchTerm[$i] >= 'A' && $searchTerm[$i] <= 'Z'))
            $newTerm = $newTerm . $searchTerm[$i];
    }
    $searchTerm = $newTerm;
    
    echo $searchTerm;
    
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
                  WHERE RecipeName LIKE '%".$_POST['recipeName']."%'
                  GROUP BY RecipeName
              ) T1";
                            
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    
    echo "count: " . $row['Total'] . "<br>";
    
    if ($row['Total'] < 5)
    {
        $html = file_get_html($allRecipesSearchUrl . $searchTerm);
        
        $allRecipes = new AllRecipesParser;
    
        $count = 0;
        foreach($html->find('h3.resultTitle') as $result)
        {
            try
            {
                // trouble here.. don't know what's going on. Sometimes no results show up!
                $result = str_replace("'", "", str_replace(" ", "-", trim($result->plaintext)));
                //$result = preg_replace("-+", "-", $result);
                
                $newResult = "";
                for ($i = 0; $i < strlen($result); $i++)
                {
                    if (($result[$i] >= 'a' && $result[$i] <= 'z') || ($result[$i] >= 'A' && $result[$i] <= 'Z'))
                        $newResult = $newResult . $result[$i];
                    if ($result[$i] == '-')
                        $newResult = $newResult . '-';
                }
                $result = $newResult;
                
                echo "result: " . $result ."<br>";
                            
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
    }
    
    echo "<a href='displayRecipeResults.php'>click here</a>";
    //header('Location: displayRecipeResults.php');
?>