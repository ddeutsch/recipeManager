<?php
    session_start();
    include("userStatus.php");
    
    checkLoggedIn($_SESSION['username']); // Make sure the user is logged in

    class AllRecipesParser
    {
        function parse($url_address)
        {
            $db_host = 'localhost:8888';
            $db_user = 'cs41512_recman';
            $db_pass = 'pass';
            $db_name = 'cs41512_recipe_db';

            $conn = mysql_connect($db_host, $db_user, $db_pass);
            if (!$conn)
            {
                echo "Error connecting to the database in " . __FILE__;
                exit();
            }
            mysql_select_db($db_name, $conn);

            $html = file_get_html($url_address);

            // For  Ingredients Table
            $recipeName = array_shift($html->find("h1"));
            $first = strrpos($recipeName, "itemprop=\"name\">") + 15;
            $last = strrpos($recipeName, "</h1>");
            $recipeName = substr($recipeName, $first + 1, $last - $first - 1);
            $recipeName = $this->cleanString($recipeName);

            $query = "SELECT COUNT(*) Count
                      FROM Recipes
                      WHERE RecipeName = '$recipeName'
                      GROUP BY RecipeName";

            $result = mysql_query($query);
            $row = mysql_fetch_array($result);

            if ($row['Count'] > 0)
            {
                //echo "getting out of here!<br>";
                return;
            }

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


            // echo "<h3> Ingredients </h3>";

            $amountArray = array();
            $nameArray = array();
            $servings = "";
            foreach($html->find('span') as $span)
            {
                if ($span->id == "lblIngAmount")
                {
                  $amount = $span->plaintext;
                  array_push($amountArray,$amount);
                  //echo "<h2>" . $amount . "</h2>";
                }

                if ($span->id == "lblIngName")
                {
                    $name = $span->plaintext;
                    $name = $this->cleanString($name);
                    array_push($nameArray,$name);
                    //echo "<h2>" . $name . "</h2>";
                }

                if ($span->id =="lblYield")
                {
                    $servings = $span->plaintext;
                    //echo "<h2> Servings: " . $servings . "</h2>";

                    // Insert Servings name into Ingredients table
                    $query = "INSERT INTO Recipes VALUES('".$recipeName. "','" .$servings."')";
                    mysql_query($query);
                }
            }

            for ($i=0; $i<sizeof($amountArray); $i++)
            {
                // Insert ingredient & recipe name into Ingredients table
                $query = "INSERT INTO Ingredients VALUES('".$recipeName. "','" .$nameArray[$i]."','" . $amountArray[$i]."')";
                $result = mysql_query($query);

                //echo $amountArray[$i] . " " . $nameArray[$i] . "<br>";
            }

            // For  Instructions Table
            $allInstructions = '';
            $i = 1;
            foreach($html->find('span.plaincharacterwrap') as $instructions)
            {
                $allInstructions = $allInstructions . $i . ": " . $instructions->plaintext . "<br>";
                $i = $i + 1;
            }

            $allInstructions = $this->cleanString($allInstructions);

           // echo $allInstructions . "<br>";

            // Insert ingredient & recipe name into Ingredients table
            $query = "INSERT INTO Instructions VALUES('".$recipeName. "','" .$allInstructions."')";
            mysql_query($query);

            //echo "error no: " . mysql_error() . "<br>";
        }

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