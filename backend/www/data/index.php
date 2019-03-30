<?php

class myUser {
	public $userid;
	public $username;
	public $email;
	public $registration_date;
	public $Country;
	public $src_app;
}


function fitDataTable ( $result ) {
	$j = 0;
	$data = array();
	foreach ($result as $row) {
		$entry = array();
		$i = 0;
		foreach ($row as $key => $value) {
			$entry[$i++] = $value;
		}
		$data[$j++] = $entry;
	}
	return array ( "data" => $data );
}


//error_log("GET  > " . print_r($_GET, true));
error_log("POST > " . print_r($_POST, true));

try {

    $hostname = "localhost";
    $dbname = "android";
    $user = "android";
    $pass = "password";

    $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
	//$dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass, array(
	//    PDO::ATTR_PERSISTENT => true
	//));

	$sth = $dbh->prepare("SELECT username, userid, Country, registration_date, email, src_app FROM Users LIMIT 80");
	$sth->execute();
	
	//$result = $sth->fetchAll();
	//$result = $sth->fetchAll(PDO::FETCH_COLUMN, );	
	$result = $sth->fetchAll(PDO::FETCH_CLASS, "myUser");

	//print_r($result);
	//die();
	
	$error = $sth->errorInfo();
	if (isset($error[1])) {
		http_response_code (500);		
		//error_log($sth->errorCode());
		//print_r($sth->errorInfo());
		die($error[1] . " " . $error[2]);
	}		

	http_response_code (200);
	header('Content-Type: application/json');
	print ( json_encode( fitDataTable ($result) ) );		

} catch (PDOException $e) {

    error_log ($e->getMessage());
    http_response_code (500);
    $result = $e->getMessage();
    
}

?>
