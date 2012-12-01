<?php
    session_start();            
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
    
    // assumption is we have a webpage and we are ready to parse
      include('simple_html_dom.php');
      //$html = file_get_html('http://allrecipes.com/recipe/chicken-cordon-bleu-ii/detail.aspx?event8=1&prop24=SR_Title&e11=chicken&e8=Quick%20Search&event10=1&e7=Home%20Page');
      //$html = file_get_html('http://allrecipes.com/recipe/frog-cupcakes/detail.aspx?event8=1&prop24=SR_Title&e11=cupcakes&e8=Quick%20Search&event10=1&e7=Recipe');
      $html = file_get_html('http://allrecipes.com/recipe/barbecued-beef/detail.aspx?event8=1&prop24=SR_Title&e11=beef&e8=Quick%20Search&event10=1&e7=Recipe');

      // For  Ingredients Table      
      $recipeName = array_shift($html->find("h1"));      
      $first = strrpos($recipeName, "itemprop=\"name\">") + 15;
      $last = strrpos($recipeName, "</h1>");
      $recipeName = substr($recipeName, $first + 1, $last - $first - 1);
      
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
            
      // Insert ingredient & recipe name into Ingredients table
        $query = "INSERT INTO Instructions VALUES
              ('".$recipeName. "','" .$allInstructions."')";
        mysql_query($query);
?>      