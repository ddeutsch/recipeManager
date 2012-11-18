<?
include 'conf.php';
include 'open.php';

$mysqli = new mysqli("dbase.cs.jhu.edu", "415_12_ddeutsc4",
    "saturnus!Spun-out", "cs41512_ddeutsc4_db");

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
		    $mysqli->multi_query("CALL ChangeCurrentUser('".$username."')");
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
