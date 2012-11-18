<?
    $db_host = 'dbase.cs.jhu.edu';
    $db_user = '415_12_ddeutsc4';
    $db_pass = 'saturnus!Spun-out';
    $db_name = 'cs41512_ddeutsc4_db';

    $conn = mysql_connect($db_host, $db_user, $db_pass);
    if (!$conn)
    {
        echo "Error connecting to the database";
        exit();
    }

    mysql_select_db($db_name, $conn);
    
    $query = "SELECT C.Username
	      FROM CurrentUser C";

    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    $username = $row[0];
    $ingredient = $_POST['ingredient'];

    $query = "INSERT INTO Cabinet VALUES ('".$username."','".$ingredient."')";
    mysql_query($query);

    header('Location: cabinet.php');
?>
