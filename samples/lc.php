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

//$sql = "select Cameras.cam_uid, Cameras.cam_name, Cameras.cam_desc, Cameras.cam_position, UserToCam.cam_permission from Cameras " 
//	. " join UserToCam on Cameras.cam_uid = UserToCam.cam_uid "
//	. " where UserToCam.userid in (select userid from Users where username = '" . $_SERVER['REMOTE_USER'] . "')";

$sql = "select Cameras.cam_uid, Cameras.cam_name, Cameras.cam_desc, Cameras.cam_position, UserToCam.cam_permission from Cameras " 
	. " join UserToCam on Cameras.cam_uid = UserToCam.cam_uid "
	. " join Uid on Uid.uid = Cameras.cam_uid "
	. " where UserToCam.userid in (select userid from Users where username = '" . $_SERVER['REMOTE_USER'] . "')"
	. " and Uid.type = 'ipertalk-pbx'";

$result = $conn->query($sql);
$ret = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        #echo "uid: " . $row["cam_uid"]. "<br>";
        $entry = array( $row["cam_uid"], $row["cam_name"], $row["cam_desc"], $row["cam_position"], trim(str_replace(":", "", $row["cam_name"])) . "|" . $row["cam_uid"] );
    	array_push($ret,  $entry);
    }
} else {
    #echo "0 results";
}
$conn->close();

$data = array();
$data["data"] = $ret;

header('Content-Type: application/json');
echo json_encode($data);

?>
