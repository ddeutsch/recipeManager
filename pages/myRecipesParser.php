<?php
session_start();

    // Testing
    // include("simple_html_dom.php");
    //$myRecipesParseObj = new MyRecipesParser;
    //$url_address = "http://www.myrecipes.com/recipe/glazed-pork-ribs-with-horseradish-apple-slaw-201610/";
    //$url_address = 'http://www.myrecipes.com/recipe/achiote-short-ribs-50400000122299/';
    //$recipe_name = "Glazed Pork Ribs With Horseradish Apple Slaw";
    //$myRecipesParseObj->parseSearch($url_address, $recipe_name);

    /**
     * This class represents the object that is used to
     * extract the significant content to us on the
     * myrecipes.com website
     */
    class MyRecipesParser
    {

      /**
       * Function to parse search html pages
       * @param string the url we want to scrape
       * @param string the name of the recipe in question
       * @param boolean true if we want print outs else false
       *
       * @return string the name of the recipe on the site
       */
      function parseSearch($url_address, $recipe_name, $verbose = false)
      {

        $recipe_name = trim($recipe_name);

        $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
        if (!$conn)
        {
            echo "Error connecting to the database in " . __FILE__;
            exit();
        }

        mysql_select_db($_SESSION['db_name'], $conn);

        $html = file_get_html($url_address);

        // This means we can get no data from the page
        //  so ignore the page
        if (gettype($html) == "boolean")
        {
            //echo "retruning!";
            return "Private page";
        }

        // get Image
        $meta = $html->find('meta');
        foreach ($meta as $m)
        {
            echo $m;
          if ($m->property == "og:image")
          {
            $image_url = $m->content;
            //echo $image_url;
          }
        }

        if ($verbose)
        {
            echo "<h2>" . $recipe_name . "</h2>";
            printf("<img src=%s />", $image_url);
            echo "<h3> Ingredients </h3>";
        }

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
                  ('".$recipe_name. "','" .$servings->plaintext."')";
            mysql_query($query);

            // Add image to DB
            $query = "INSERT INTO Images VALUES
                ('".$recipe_name."','" .$image_url. "')";
            mysql_query($query);
          }
        }

        // echo "<br> Serving = $servings <br><br>";

        for ($i=0; $i<sizeof($amountArray); $i++)
          {
          // Insert ingredient & recipe name into Ingredients table
          $query = "INSERT INTO Ingredients VALUES
                ('".$recipe_name. "','" .trim($nameArray[$i]->plaintext)."','" . $amountArray[$i]->plaintext."')";
          mysql_query($query);
              if ($verbose)
              {
              echo $amountArray[$i] . " " . $nameArray[$i] . "<br>";
              }
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
          if ($verbose)
          {
              echo $finInstr;
          }

        // Insert ingredient & recipe name into Ingredients table
          $query = "INSERT INTO Instructions VALUES
                ('".$recipe_name. "','" .$finInstr."')";
          mysql_query($query);
        return $recipe_name;
      }

      /**
       * Function to parse specialities html
       *@param string the url we want to scrape
       *@param string the image url of the recipe
       *@param boolean true if we want print outs else false
       */
        function parse($url_address, $image_url, $verbose = false)
      {

        $conn = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']);
        if (!$conn)
        {
            echo "Error connecting to the database in " . __FILE__;
            exit();
        }

        mysql_select_db($_SESSION['db_name'], $conn);

          $html = file_get_html($url_address);

          // For  Ingredients Table
          $recipeName = array_shift($html->find("meta[name='recipe_name']"))->content;

            if ($verbose)
            {
                echo "<h2>" . $recipeName . "</h2>";
                printf("<img src=%s />", $image_url);
                echo "<h3> Ingredients </h3>";
            }

          $nameArray = array(); // Array to hold the name of the ingredients
          $amountArray = array(); // Array to hold the amount of each corresponding ingredient
          $servings = ""; // String holding the number of servings possible
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

            // Add image to DB
            $query = "INSERT INTO Images VALUES
                ('".$recipeName."','" .trim($image_url). "')";
            }
            mysql_query($query);
          }

          // echo "<br> Serving = $servings <br><br>";

          for ($i=0; $i<sizeof($amountArray); $i++)
            {
            // Insert ingredient & recipe name into Ingredients table
            $query = "INSERT INTO Ingredients VALUES
                  ('".$recipeName. "','" .$nameArray[$i]->plaintext."','" . $amountArray[$i]->plaintext."')";
            mysql_query($query);
                if ($verbose)
                {
                echo $amountArray[$i] . " " . $nameArray[$i] . "<br>";
                }
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
            if ($verbose)
            {
                echo $finInstr;
            }

          // Insert ingredient & recipe name into Ingredients table
            $query = "INSERT INTO Instructions VALUES
                  ('".$recipeName. "','" .$finInstr."')";
            mysql_query($query);
        return $finInstr;
      }
    }
?>