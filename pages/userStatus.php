<?php

  /**
   *Return a user to the login page if they try to access to site illegally
   *i.e without signing in
   *@param string the $_SESSION['username']
   */
  function checkLoggedIn($username)
  {
    if (!isset($username))
    {
      header('Location: index.php');
    }
  }
?>