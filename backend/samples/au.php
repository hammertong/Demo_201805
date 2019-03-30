<?php
require_once('cgi/conf/parameters.php');
global $cloud_db, $db_addr, $db_user, $db_psw;
$username = $_SERVER['REMOTE_USER'];
if (!isset($username)) {
  header('HTTP/1.1 403 Forbidden');
  die("FORBIDDEN");
} 

$servername = "$db_addr";
$username = "$db_user";
$password = "$db_psw";
$dbname = "$cloud_db";


#echo "$servername, $username, $password, $dbname";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$ret = array();

header('Content-Type: application/json');
#if (isempty($_GET["q"])) die(json_encode($ret));

$sql = "select `uid`, `Mac_Address` from Uid where uid like '" .  $_GET["q"] . "%' and type = 'ipertalk-pbx' limit 6";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	array_push($ret, $row["uid"] . "," . $row["Mac_Address"]);
    	#array_push($ret, $row["uid"] );
    }
} else {
    #echo "0 results";
}
$conn->close();

echo json_encode($ret);


?>
