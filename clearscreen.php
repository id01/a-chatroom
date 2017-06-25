<?php
	include "config/permissions.php";
	include "config/config.php";
	session_set_cookie_params(0, substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT'])));
	session_start();
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
		if ($_USERALLOW["clear"] <= $_SESSION["usertype"])
		{
			file_put_contents("data/messages.txt", "<span class='" . $spanclass . "'>" . $username . "</span> cleared the room.<br /><br />\n");
			file_put_contents("data/number.txt", 0);
		}
	}
	else
	{
		include 'logout.php';
	}
?>

