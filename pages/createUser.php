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

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$username = $_POST["username"];
$password = $_POST["password"];


if ($mysqli->multi_query("CALL CreateUser('".$username."','".$password."', '".$fname."', '".$lname."');"))
{
    do
    {
	if ($result = $mysqli->store_result())
	{
	    $finfo = $result->fetch_fields();

	    # length == 1 if Error Message
	    if (count($finfo) == 1)
		printf("Sorry, Username already exists");
	    else
	    {
		$mysqli->multi_query("CALL ChangeCurrentUser('".$username."')");
		
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
