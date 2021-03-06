<!-- This class creates a user by first checking to see if that username exists, then it creates
the user in the database if allowed. If successful, it will log the user in and redirect
to the home page. -->

<?php
    session_start(); // Initiate session data log
    
    $mysqli = new mysqli($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name']);

    if (mysqli_connect_errno())
    {
	printf("Connect failed: %s<br>", mysqli_connect_error());
	exit();
    }

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $password = sha1($_POST["password"]);

    $_SESSION['username'] = $username; // store username in session data

    if ($mysqli->multi_query("CALL CreateUser('".$username."','".$password."', '".$fname."', '".$lname."');"))
    {
	do
	{
	    if ($result = $mysqli->store_result())
	    {
		$finfo = $result->fetch_fields();

		# length == 1 if Error Message
		if (count($finfo) == 1)
		{
		    $_SESSION['DUPLICATE_USERNAME'] = true;
		    header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		else
		{
		    header('Location: homePage.php');
		}
		$result->close();
	    }
	} while ($mysqli->next_result());

    }
    else
	printf("<br>Error: %s\n", $mysqli->error);
    ?>
</body>
</html>
