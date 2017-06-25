<?php
	include "../config/config.php";
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
if ($_SESSION["userhash"] == strtoupper(hash('sha1', 'admin')) && time() < $_SESSION["expiry"])
{
	// Check if password verification is right
	if (hash('sha256', crypt($_POST["pass"], 'admin')) == $_CONFIG["adminhash"])
	{
		if ($_POST["action"] == "reset")
		{
			shell_exec("cd .. && ./clear.sh");
		}
		if ($_POST["action"] == "u1")
		{
			$usersha = strtoupper(hash('sha1', $_POST["user"]));
			$userhashpass = shell_exec("grep " . $usersha . " ../loginfile.txt | cut -d ' ' -f 1,2");
			shell_exec("grep -v " . $usersha . " ../loginfile.txt > /tmp/loginfiletmp.txt");
			shell_exec("(cat /tmp/loginfiletmp.txt && echo '" . trim($userhashpass) . " 0') > ../loginfile.txt; rm /tmp/loginfiletmp.txt");
		}
		if ($_POST["action"] == "u2")
		{
			$usersha = strtoupper(hash('sha1', $_POST["user"]));
                        $userhashpass = shell_exec("grep " . $usersha . " ../loginfile.txt | cut -d ' ' -f 1,2");
                        shell_exec("grep -v " . $usersha . " ../loginfile.txt > /tmp/loginfiletmp.txt");
                        shell_exec("(cat /tmp/loginfiletmp.txt && echo '" . trim($userhashpass) . " 1') > ../loginfile.txt; rm /tmp/loginfiletmp.txt");
		}
		if ($_POST["action"] == "mod")
		{
			$usersha = strtoupper(hash('sha1', $_POST["user"]));
                        $userhashpass = shell_exec("grep " . $usersha . " ../loginfile.txt | cut -d ' ' -f 1,2");
                        shell_exec("grep -v " . $usersha . " ../loginfile.txt > /tmp/loginfiletmp.txt");
                        shell_exec("(cat /tmp/loginfiletmp.txt && echo '" . trim($userhashpass) . " 2') > ../loginfile.txt; rm /tmp/loginfiletmp.txt");
		}
		echo "<p>The deed is done.</p>";
	}
	else
	{
		echo "<p>Wrong password. Try again.</p>";
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
