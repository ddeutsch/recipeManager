<?php
  session_start();
?>

<html>
  <head>
    <!--<meta http-equiv="refresh" content="1;url=results.php"> -->
  </head>
  <body>
    
    <?php
      //include(crawler.php); // Implement the crawler here then simply include
      
      include("PHPCrawl_081/libs/PHPCrawler.class.php");
      
      class MyCrawler extends PHPCrawler
      { 
        function handleDocumentInfo(PHPCrawlerDocumentInfo $PageInfo) 
        {
          
          
          echo $PageInfo->url;
          echo $PageInfo->content;
          
        }        
      }
      
      //<h3> Ingredients </h>
      // recipe name: <h1 class="x4-headline" itemprop="name">Chicken Curry</h1>
      //ingredients: itemprop="name"
      
      
      $crawler = new MyCrawler(); 
      $crawler->setURL("http://www.myrecipes.com/");  // Root URL
      $crawler->addContentTypeReceiveRule("#text/html#"); // What files to search
      $crawler->setTrafficLimit(1000 * 1024); // While running locally 1MB limit
      $crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i"); // Things we don't want
      $crawler->enableCookieHandling(true);
      
      $crawler->setFollowMode(3); //
      
      
      $crawler->go(); // Launch crawl
      //$crawler->goMultiProcessed(3, PHPCrawlerMultiProcessModes::MPMODE_PARENT_EXECUTES_USERCODE);// unix-linux only
      $report = $crawler->getProcessReport();
      
      if (PHP_SAPI == "cli") $lb = "\n"; 
      else $lb = "<br />"; 
           
      echo "Summary:".$lb; 
      echo "Links followed: ".$report->links_followed.$lb; 
      echo "Documents received: ".$report->files_received.$lb; 
      echo "Bytes received: ".$report->bytes_received." bytes".$lb; 
      echo "Process runtime: ".$report->process_runtime." sec".$lb;
      
      
      
    ?>
    
  </body>
</html>