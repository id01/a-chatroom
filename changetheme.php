<html>
<title>Theme</title>
<head>
<link type="text/css" rel="stylesheet" href="config/themes/default.css">
<script src="themesource.js"></script>
<script src="config/title.js"></script>
<script>
function changetheme() {
	var themeselect = document.getElementById("themeselect");
	document.cookie = "theme=" + themeselect.options[themeselect.selectedIndex].text + ".css;";
	window.location.replace('changetheme.php');
}
</script>
</head>
<body>
<p>This script changes the theme of the website.</p>
New theme:
<select id="themeselect">
<option>-- Available themes --</option>
<option>
<?php
	$themefiles = array_diff(scandir("config/themes"), array('.', '..'));
	$themes = array();
	foreach ($themefiles as $themefile)
	{
		array_push($themes, substr($themefile,0,-4));
	}
	echo implode("</option><option>", $themes);
?>
</option>
</select>
<button type="button" onclick="changetheme()">Change</button>
<br />
<br />
<a href="index.php">Return</a>
</body>
</html>
