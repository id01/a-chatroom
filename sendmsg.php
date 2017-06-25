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
			$messagefile = fopen("data/messages.txt", "a");
			fwrite($messagefile, "<span class='" . $spanclass . "'>" . $username . "</span>: " . $message . "<br /><br />\n");
			fclose($messagefile);
			$number = (int)trim(file_get_contents("data/number.txt"))+1;
			file_put_contents("data/number.txt", $number);
			if ((int)exec("wc -l data/messages.txt")>$_CONFIG["maxmessages"]) {
				$msgFile = file("data/messages.txt");
				array_shift($msgFile);
				file_put_contents("data/messages.txt", $msgFile);
			}
		}
	}
	else
	{
		include 'logout.php';
	}
?>

