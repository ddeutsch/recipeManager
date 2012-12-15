<?php

  /**
   *Return a user to the login page if they try to access to site illegally
   *i.e without signing in
   *@param string the $_SESSION['username']
   */
  function checkLoggedIn($username)
  {
    echo gettype($username);
    if (!isset($username) || gettype($username) == "NULL" )
    {
      header('Location: index.php');
    }
  }
?>