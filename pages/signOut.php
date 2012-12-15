<!-- Signs a user out. -->

<?php
  session_start();
  session_unset();

  header("Location: index.php");
      print('<html>
      <head>
        <meta http-equiv="refresh" content="0;url=./index.php">
        <?php
          session_destroy();
        ?>
      </head>
    </html>');
?>