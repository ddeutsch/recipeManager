<!-- This class is responsible for parsing a search page on http://www.allrecipes.com -->

<?php
    session_start();
    class AllRecipesParser
    {
        /**
        * This method performs the parsing of the webpage.
        *
        * @param (String) $url_address should be the url address of the web page to parse, i.e.,
        * it should be the recipe page
        */
        function parse($url_address)
        {
            $db_host = 'localhost:8888';
            $db_user = 'cs41512_recman';
            $db_pass = 'pass';
            $db_name = 'cs41512_recipe_db';

            $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
            if (!$conn)
            {
                echo "Error connecting to the database in " . __FILE__;
                exit();
            }
            mysql_select_db($db_name, $conn);
            
            $html = file_get_html($url_address);

            // Get the name of the recipe
            $recipeName = array_shift($html->find("h1"));
            $first = strrpos($recipeName, "itemprop=\"name\">") + 15;
            $last = strrpos($recipeName, "</h1>");
            $recipeName = substr($recipeName, $first + 1, $last - $first - 1);
            $recipeName = $this->cleanString($recipeName);
            
            // Check to see if we already have this recipe in the database
            $query = "SELECT COUNT(*) Count
                      FROM Recipes
                      WHERE RecipeName = '$recipeName'
                      GROUP BY RecipeName";
                      
            $result = mysql_query($query);
            $row = mysql_fetch_array($result);

            // if true, recipe already exists
            if ($row['Count'] > 0)
                return;

            // find the recipe's image
            foreach($html->find('meta') as $meta)
            {
                $image = "";
                if ($meta->id == "metaOpenGraphImage")
                {
                    $image = $meta->content;

                    $query = "INSERT INTO Images VALUES('".$recipeName. "','" .$image."')";
                    mysql_query($query);

                    break;
                }

            }

            // create the ingredients table
            $amountArray = array();
            $nameArray = array();
            $servings = "";
            foreach($html->find('span') as $span)
            {
                // the amount of the ingredient
                if ($span->id == "lblIngAmount")
                {
                  $amount = $span->plaintext;
                  array_push($amountArray,$amount);
                }

                // the name of the ingredient
                if ($span->id == "lblIngName")
                {
                    $name = $span->plaintext;
                    $name = $this->cleanString($name);
                    array_push($nameArray,$name);
                }

                // the number of servings
                if ($span->id =="lblYield")
                {
                    $servings = $span->plaintext;
                    $query = "INSERT INTO Recipes VALUES('".$recipeName. "','" .$servings."')";
                    mysql_query($query);
                }
            }

            // insert values into the Ingredients table
            for ($i=0; $i<sizeof($amountArray); $i++)
            {
                $query = "INSERT INTO Ingredients VALUES('".$recipeName. "','" .$nameArray[$i]."','" . $amountArray[$i]."')";
                $result = mysql_query($query);
            }

            // parse the instructions, numbering them starting at 1
            $allInstructions = '';
            $i = 1;
            foreach($html->find('span.plaincharacterwrap') as $instructions)
            {
                $allInstructions = $allInstructions . $i . ": " . $instructions->plaintext . "<br>";
                $i = $i + 1;
            }

            $allInstructions = $this->cleanString($allInstructions);

            // Insert ingredient & recipe name into Ingredients table
            $query = "INSERT INTO Instructions VALUES('".$recipeName. "','" .$allInstructions."')";
            mysql_query($query);
        }

        /**
         * Cleans up a string to bad input. Removes any non-ASCII values and places MySQL
         * escape characters where necessary
         *
         * @param (String) $string The string to clean up.
         */
        function cleanString($string)
        {
            $newString = "";
            for ($i = 0; $i < strlen($string); $i++)
            {
                if ($string[$i] == '%')
                    $newString = $newString . "\\\%";
                else if ($string[$i] == '\'')
                    $newString = $newString . "\\'";
                else if ($string[$i] == '\"')
                    $newString = $newString . "\\\"";
                else
                    $newString = $newString . $string[$i];
            }
            return ($newString);
        }
    }
?>