<?php
	include "../config/config.php";
	include "../config/permissions.php";
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../config/themes/default.css">
<script src="themesource.js"></script>
</head>
<body>
<?php
$thisdir = substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT']));
session_set_cookie_params(0, substr($thisdir, 0, strlen($thisdir)-5));
session_start();
// Check if logged in as admin user
if ($_SESSION["usertype"] >= $_USERALLOW["kick"] && time() < $_SESSION["expiry"])
{
	$userlower = strtolower($_POST["user"]);
	$userhash = strtoupper(hash('sha1', $userlower));
	$userprev = (int)trim(exec("grep " . $userhash . " ../messages.txt | cut -d 3"));
	if ($userlower == 'admin')
	{
		echo "<p>You can't kick the <span class='adminname'>admin</span></p>";
	}
	else if ($userprev >= $_SESSION["usertype"])
	{
		switch ($userprev)
		{
			case 1: echo "<p>You don't have sufficient permissions to kick another level 2 user.</p>"; break;
			case 2: echo "<p>This user is a <span class='modname'>moderator</span>, and only the admin can kick them.</p>"; break;
			default: echo "<p>Something went wrong... Terribly terribly wrong.</p>"; break;
		}
	}
	else if ($_POST["action"] == "kick")
	{
		$kickfile = fopen("../restricted.txt", "a");
		fwrite($kickfile, $userhash . "\n");
		fclose($kickfile);
               	echo "<p>The deed is done.</p>";
	}
	else if ($_POST["action"] == "ban")
	{
		$banfile = fopen("../banned.txt", "a");
		fwrite($banfile, $userhash . "\n");
		fclose($banfile);
		echo "<p>The deed is done.</p>";
	}
	else
	{
		echo "<p>Something's went wrong... Terribly terribly wrong.</p>";
	}
}
else
{
	echo "<p>HACKER!!!</p>";
}
?>
<meta http-equiv="refresh" content="1;../index.php">
</body>
</html>
