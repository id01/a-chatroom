<?php
// Initializes config
$_CONFIG=array();

// Administrator password hash
$_CONFIG["adminhash"]="19dd062023db6b69a77206e3e0902a4f5d49c0198a51bb3395337127ccdb53f3";

// Refresh rate in milleseconds. If short polling, this is delay between polls. If long polling, this is delay between checks on the server.
$_CONFIG["refreshrate"]=100;

// Long poll timeout (if applicable) in microseconds
$_CONFIG["lptimeout"] = 5*1000000;

// Maximum messages stored, multiplied by 2
$_CONFIG["maxmessages"] = 24;

// Maximum length of non-long message
$_CONFIG["maxlen"] = 512;

// 0 for short, 1 for hybrid, 3 for long
$_CONFIG["polltype"] = 1;
?>
