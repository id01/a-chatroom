<?php
	include "config/permissions.php";
	include "config/config.php";
	session_set_cookie_params(0, substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT'])));
	session_start();
	$message = $_POST["message"];
	$username = $_COOKIE["username"];
	$usernametesthash = strtoupper(hash('sha1', strtolower($username)));
	if ($_SESSION["userhash"] == $usernametesthash && time() < $_SESSION["expiry"])
	{
		$_SESSION["expiry"] = time()+600;
		setcookie("username", $username, time()+600);
		if ($username == "admin")
		{
			$spanclass="adminname";
		}
		else if ($_SESSION["usertype"] == 2)
		{
			$spanclass="modname";
		}
		else if ($_SESSION["usertype"] == 1)
		{
			$spanclass="user2name";
		}
		else
		{
			$spanclass="username";
		}
		if ($_USERALLOW["long"] > $_SESSION["usertype"] && strlen($message)>$_CONFIG["maxlen"])
			$message=" -- message too long -- ";
		if ($_USERALLOW["send"] <= $_SESSION["usertype"])
		{
			$message = str_replace("&", "&amp;", $message);
		        $message = str_replace("<", "&lt;", $message);
		        $message = str_replace(">", "&gt;", $message);
			$messagefile = fopen("messages.txt", "a");
			fwrite($messagefile, "<span class='" . $spanclass . "'>" . $username . "</span>: " . $message . "<br /><br />\n");
			fclose($messagefile);
			$number = (int)trim(file_get_contents("number.txt"))+1;
			file_put_contents("number.txt", $number);
			if ((int)$number%4 == 0 && (int)exec("wc -l messages.txt")>$_CONFIG["maxmessages"])
				shell_exec("tail -n " . $_CONFIG["maxmessages"] . " messages.txt > /tmp/.messages2.txt && cat /tmp/.messages2.txt > messages.txt");
		}
	}
	else
	{
		include 'logout.php';
	}
?>

