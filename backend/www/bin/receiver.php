<?php

if (php_sapi_name() != "cli") {    
 	header("HTTP/1.0 403 Forbidden");
 	die ("403 You are forbidden");
}

for ($i = 1; $i < count($argv); $i ++) {
    if ($argv[$i] == "--topic" || $argv[$i] == "-t") {
        $token = $argv[++$i];
    }
    else {
        error_log("invalid option: " . $argv[$i]);
    } 
}

error_log("Receiving commands ...");

while($line = fgets(STDIN)){	
    
	echo "RECV > $line";

}

?>