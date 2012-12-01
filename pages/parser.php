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
      //$html = file_get_html('http://www.myrecipes.com/recipe/italian-chicken-artichokes-10000000635678/'); // TODO : DM
      //$html = file_get_html('http://www.myrecipes.com/recipe/beef-tenderloin-with-mustard-herbs-10000001809088/'); // TODO : DM      
      $html = file_get_html('http://www.myrecipes.com/recipe/slow-roasted-beef-with-creamy-mashed-potatoes-10000001041881/'); // TODO : DM
      
      // For  Ingredients Table
      $recipeName = array_shift($html->find("meta[name='recipe_name']"))->content;
      
      // echo "<h2>" . $recipeName . "</h2>";
      
      // echo "<h3> Ingredients </h3>";
      
      $amountArray = array();
      $nameArray = array();
      $servings = "";
      foreach($html->find('span') as $span)
      {
        if ($span->itemprop == "amount")
        {
          $amount = $span;
          array_push($amountArray,$span);
        }
        
        if ($span->itemprop == "name")
        {
          $name = $span;
          array_push($nameArray,$span);
        }
        
        if ($span->itemprop =="yield")
        {
          $servings = $span;
        // Insert Servings name into Ingredients table
        $query = "INSERT INTO Recipes VALUES
              ('".$recipeName. "','" .$servings->plaintext."')";
        mysql_query($query);
        }          
      }
      
      // echo "<br> Serving = $servings <br><br>";
      
      for ($i=0; $i<sizeof($amountArray); $i++)
        {
        // Insert ingredient & recipe name into Ingredients table
        $query = "INSERT INTO Ingredients VALUES
              ('".$recipeName. "','" .$nameArray[$i]->plaintext."','" . $amountArray[$i]->plaintext."')";
        mysql_query($query);
        // echo $amountArray[$i] . " " . $nameArray[$i] . "<br>";
        }
        
      // For  Instructions Table
      // echo "<h3> Instructions </h3>";
      foreach($html->find('ol') as $instructions)
              {
                if ($instructions->itemprop == "instructions")
                {
                   $token = preg_split("[\d\. ]",$instructions->plaintext); // Get rid of bullets
                }
              }
      
      $finInstr = "";      
      foreach($token as $t)
      {  
        $finInstr = $finInstr.$t; // Concatenate all instructions so they are a single item 
      }
        
      // echo $finInstr;
    
      // Insert ingredient & recipe name into Ingredients table
        $query = "INSERT INTO Instructions VALUES
              ('".$recipeName. "','" .$finInstr."')";
        mysql_query($query);
?>      