<?php
session_start(); // Initiate session data log

include 'conf.php';
include 'open.php';

$mysqli = new mysqli("localhost", "cs41512_recipe_manager",
    "pass", "cs41512_recipe_db");

if (mysqli_connect_errno())
{
    printf("Connect failed: %s<br>", mysqli_connect_error());
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];


if ($mysqli->multi_query("CALL ValidateUser('".$username."','".$password."');"))
{
    if (empty($username) || empty($password))
	printf("Error! You need to enter a username and password");
    else
    {
	do
	{
	    if ($result = $mysqli->store_result())
	    {
		$finfo = $result->fetch_fields();

		# length == 1 if Error Message
		if (count($finfo) == 1)
		    printf("Sorry, invalid username or password");
		else
		{
		    //$mysqli->multi_query("CALL ChangeCurrentUser('".$username."')");
		    $_SESSION['username'] = $username; // store username in session data
		    header('Location: homePage.php');
		}
		$result->close();
	    }
	} while ($mysqli->next_result());
    }																		    
}
else
    printf("<br>Error: %s\n", $mysqli->error);
?>
</body>
</html>
