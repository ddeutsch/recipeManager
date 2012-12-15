<!-- Signs a user out. -->

<?php
  session_start();
  session_unset();

  header("Location: index.php");
?>