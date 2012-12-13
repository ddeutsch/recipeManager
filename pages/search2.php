<!-- This script takes the user's search term, then finds all of the recipe names from http://www.allrecipes.com
that match the search term. Once it has a recipe name, it calls the allRecipes parser and provides it
the url to that recipe. -->

<?php
    session_start();

    class allRecipesSearch
    {
        /**
        * This function parses the search results page for each recipe name.
        *
        * @param (String) $searchTerm The search term.
        */
        function webSearch($searchTerm)
        {            
            $allRecipesSearchUrl = "http://allrecipes.com/search/default.aspx?wt=";
            $html = file_get_html($allRecipesSearchUrl . $searchTerm);
            
            // if true, something failed
            if (gettype($html) == "boolean")
                return;

            $allRecipes = new AllRecipesParser;
            
            $count = 0;
            
            // h3.resultTitle is specific to allrecipes.com
            foreach($html->find('h3.resultTitle') as $result)
            {
                $result = $result->plaintext;
                try
                {
                    $text = (string)$result;
                    $result = $this->parseSearchTerm($text);
                                        
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
        * @param string The search term
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