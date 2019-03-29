<?php

if (php_sapi_name() != "cli") {    
 	header("HTTP/1.0 403 Forbidden");
 	die ("403 You are forbidden");
}

$port = 56743;
$message = "";

for ($i = 1; $i < count($argv); $i ++) {
    if ($argv[$i] == "--port" || $argv[$i] == "-p") {
        $port = intval($argv[++$i]);
    }
    else if ($argv[$i] == "--message" || $argv[$i] == "-m") {
        $message = $argv[++$i];
    }
    else {
        error_log("invalid option: " . $argv[$i]);
    } 
}

if (strlen($message) == 0) {
	die("You must specify message with -m option\n");
}


$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
$broadcast_string = $message;
while(true){
	error_log("broadcasting '$message' on port $port ...");
	socket_sendto($sock, $broadcast_string, strlen($broadcast_string), 0, '255.255.255.255', $port); 
	sleep(3);
}

?>
