<?php
    //include('simple_html_dom.php');
    //include('AllRecipesParser.php');
    session_start();

    class allRecipesSearch
    {
        function webSearch($searchTerm)
        {            
            $allRecipesSearchUrl = "http://allrecipes.com/search/default.aspx?wt=";
            $html = file_get_html($allRecipesSearchUrl . $searchTerm);

            $allRecipes = new AllRecipesParser;
            
            $count = 0;
            foreach($html->find('h3.resultTitle') as $result)
            {
                $result = $result->plaintext;
                try
                {
                    // trouble here.. don't know what's going on. Sometimes no results show up!
                    $text = (string)$result;
                    $result = $this->parseSearchTerm($text);
                    
                    echo "result: $result<br>";
                    
                    $allRecipes->parse("http://allrecipes.com/recipe/" . $result);

                    $count = $count + 1;
                    if ($count >= 10)
                        break;
                }
                catch (Exception $e)
                {
                    echo "Got an exception<br>";
                    // do nothing
                }
            }
            return $count;
        }

        /**
        * Parse search term appropriately for use in allRecipes search
        *@param string The search term
        */
       function parseSearchTerm($searchTerm)
       {
            $searchTerm = trim($searchTerm);
            $newTerm = "";
            
            for ($i = 0; $i < strlen($searchTerm); $i++)
            {
                if ($searchTerm[$i] == ' ' || $searchTerm[$i] == '-')
                    $newTerm = $newTerm . '-';
                else if (($searchTerm[$i] >= 'a' && $searchTerm[$i] <= 'z') || ($searchTerm[$i] >= 'A' && $searchTerm[$i] <= 'Z'))
                    $newTerm = $newTerm . $searchTerm[$i];
                    
            }

            $newTerm = preg_replace("/-+/", "-", $newTerm);
            return $newTerm;
       }


    }
?>