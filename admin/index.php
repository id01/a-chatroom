<?php
include "../config/permissions.php";
$thisdir = substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT']));
session_set_cookie_params(0, substr($thisdir, 0, strlen($thisdir)-5));
session_start();
if ($_SESSION["userhash"] == "")
{
	echo "<script>window.location.replace('../login.php?note=0')</script>";
}
?>
<html>
<title>Admin Panel</title>
<head>
<link type="text/css" rel="stylesheet" href="../config/themes/default.css">
<script src="themesource.js"></script>
<script src="../config/title.js"></script>
</head>
<body>
<p>DANGER! These commands may have VERY, VERY bad effects if used incorrectly.</p>
<div>
<form method="post" action="kick.php" <?php if ($_SESSION["usertype"] < $_USERALLOW["kick"]) echo 'style="display:none"'; ?>>
<select name="action">
	<option>-- Kick actions --</option>
	<option value="kick">Kick user - Kicks a username.</option>
	<option value="ban">Ban user - Bans a user and their ip.</option>
</select>
User: <input type="text" name="user">
<input type="submit" value="Submit">
</form>
</div>
<br />
<div>
<form method="post" action="sudo.php" <?php if ($_SESSION["usertype"] < 3) echo 'style="display:none"'; ?>>
<select name="action">
	<option>-- Sudo actions --</option>
	<option value="reset">Reset room - DANGER! THIS WILL CLEAR EVERYTHING!</option>
	<option value="u1">Change a user to basic user</option>
	<option value="u2">Change a user to user level 2</option>
	<option value="mod">Change a user to moderator</option>
</select>
User: <input type="text" name="user">
Verify admin pass: <input type="password" name="pass">
<input type="submit" value="Sudo it!">
</form>
</div>
</body>
</html>
