<?php
	include "config/config.php";
	$refreshrate = $_CONFIG["refreshrate"] * 1000; // Get configuration longpolling refresh rate
	$numberprev = $_COOKIE["number"]; // Get user cookie "number"
        $number = ((int)file_get_contents("number.txt")); // Get file content "number"
	$usecs = 0; // Start timer
	while ( $number == $numberprev && $usecs < $_CONFIG["lptimeout"] ) // Expire if number != numberprev and seconds >= config[lptimeout]
	{
		usleep($refreshrate); // Let my server rest for refreshrate
		$number = (int)(file_get_contents("number.txt")); // Get file content again
		$usecs += $refreshrate; // Add refreshrate to timer
	}
	echo $number;
?>
