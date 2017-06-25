<?php
session_set_cookie_params(0, substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT'])));
session_start();
$_SESSION = array();
session_destroy();
setcookie("username", '', time()-1);
setcookie("PHPSESSID", '', time()-1);
?>
<html>
<title>Logout</title>
<head>
<link type="text/css" rel="stylesheet" href="config/themes/default.css">
<script src="themesource.js"></script>
<script src="config/title.js"></script>
</head>
<body>
<meta http-equiv="refresh" content="1;url=login.html?note=0">
Session ended.
</body>
</html>
