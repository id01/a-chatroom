<?php
	// Configuration
        include "config/config.php";
	include "config/permissions.php";
        // Login actions
        include "login-source.php";
        session_set_cookie_params(0, substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT'])));
        session_start();
?>
<html>
<title>Messages</title>
<head>
<link type="text/css" rel="stylesheet" href="config/themes/default.css">
<!-- Script declaraction -->
<script src="/bootstrap/js/jquery.js"></script>
<script src="themesource.js"></script>
<script src="config/title.js"></script>
<!-- Disable Caching -->
<script>
$.ajaxSetup({
	cache: false
});
</script>
</head>

<!-- Break -->

<body>
<!-- Refresh Number -->
<p><span id="newnumber">Loading...</span><span id="numberarrows"> >> </span><span id="number">Waiting...</span></p>
<!-- Messagebox -->
<div id="messagebox">
Loading Messages...
</div>
<!-- Javascript Declarations -->
<script src="java-source.js"></script>
<br />
<!-- Message Sender -->
<form id="msgsnd" action="sendmsg()" method="post">
	<input type="submit" name="send" value="Send" style="float: right">
	<div style="overflow: hidden; padding-right: .5em;">
		<input type="text" name="message" style="width: 100%;" autocomplete="off">
	</div>
</form>
<!-- Buttons -->
<div style="float: right">
<button id="logoutbutton" type="button" onclick="logout()">Logout</button> &nbsp;
<form id="clearform" action="clr()" style="display: inline-block; margin: 0" method="post">
	<input id="clearbutton" type="submit" name="Clear" value="Clear"> &nbsp;
</form>
<button id="refreshbutton" type="button" onclick="frefresh()">Refresh</button>
</div>
<div><p>&nbsp;</p></div>
<div style="float: right">
<button id="adminbutton" type="button" onclick="window.location.replace('admin');">Admin Panel</button> &nbsp;
<button id="themebutton" type="button" onclick="window.location.replace('changetheme.php');">Theme</button>
</div>
<a href="help.html" style="position: absolute; bottom: 5; right: 5; float: right; font-size: 10">Help</a>
<script>
<?php
if ($_SESSION["usertype"] < $_USERALLOW["kick"])
{
	echo "document.getElementById('adminbutton').className = 'disabledbutton';";
	echo "document.getElementById('adminbutton').disabled = 'disabled';";
	echo "document.getElementById('adminbutton').id = 'adminbuttondisabled';";
}
if ($_SESSION["usertype"] < $_USERALLOW["clear"])
{
	echo "document.getElementById('clearbutton').disabled = 'disabled';";
	echo "document.getElementById('clearbutton').className = 'disabledbutton';";
	echo "document.getElementById('clearbutton').id = 'clearbuttondisabled';";
}
if ($_SESSION["usertype"] < $_USERALLOW["send"])
{
	echo "document.getElementById('msgsnd').style = 'display:none';";
}
?>
var polltype = <?php echo $_CONFIG["polltype"]; ?>;
if ( polltype == 0 )
{
	frefresh();
	setInterval(function() { refresh(0); }, <?php echo $_CONFIG["refreshrate"]; ?>);
}
else if ( polltype == 1 || polltype == 3 )
{
	document.cookie="number=-1";
	refresh(1);
	document.getElementById("numberarrows").style = "display:none";
	document.getElementById("newnumber").style = "display:none";
	document.getElementById("number").style = "display:none";
}
</script>
</body>
</html>
