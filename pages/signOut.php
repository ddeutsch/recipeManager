<!-- Signs a user out. -->

<?php
  session_start();
  session_unset();
  session_destroy();

  header("Location: index.html");
?>