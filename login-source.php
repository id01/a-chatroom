<?php
	// If logged in already, pass.
	if (isset($_COOKIE["username"]))
	{
		echo "<p id='notification'>Logged in.</p>";
	}
        // If not logged in redirect to login page
        else if ($_POST["username"] == "")
        {
                echo "<script>window.location.replace('login.html?note=0');</script>";
        }
	else
	{
	// If username is booby trapped
	$_POST["username"] = str_replace("&", "&amp;", $_POST["username"]);
	$_POST["username"] = str_replace("<", "&lt;", $_POST["username"]);
	$_POST["username"] = str_replace(">", "&gt;", $_POST["username"]);
	if (!(strpos($_POST["username"], "'") === true || strpos($_POST["username"], "\\") === true))
	{
		$readytocontinue = true;
	}
	else
	{
		echo "<script>window.location.replace('login.html?note=4');</script>";
		$readytocontinue = false;
	}
	// Compute hash for username
        $userlower=strtolower($_POST["username"]);
        $usersha=strtoupper(hash('sha1', $userlower));
	// Check for restricted usernames
	if ($readytocontinue == true) {
	if (shell_exec("cat data/restricted.txt | grep '^" . $usersha . "$'") != "")
	{
		echo "<script>window.location.replace('login.html?note=3');</script>";
	}
	// Check for banned usernames
	else if ($userlower != 'admin' && shell_exec("cat data/banned.txt | grep '^" . $usersha . "$'") != "")
	{
		file_put_contents("data/banned.txt", md5($_SERVER['REMOTE_ADDR'])."\n", FILE_APPEND);
		echo "<script>window.location.replace('banned.html');</script>";
	}
	else
	{
        	// Login
		// Check if username exists
		$usersaveraw=preg_grep('/^'.$usersha.'/', file("data/loginfile.txt"));
		if (empty($usersaveraw))
			$usersave="";
		else
			$usersave=array_shift($usersaveraw);
		// If username does not exist, create the user and reload
	        if ($usersave == "")
	        {
			file_put_contents("data/loginfile.txt", $usersha . " " . hash('sha256', crypt($_POST["password"], $userlower)) . " 0\n", FILE_APPEND);
	                echo "<script>window.location.replace('login.html?note=1');</script>";
	        }
	        else
	        {
			$usa = explode(" ", $usersave); // UserSaveArray
			// Get password hash of username specified
			$linecont = $usa[1];
	                $hash = hash('sha256', crypt($_POST["password"], $userlower));
			// If password specified matches...
	                if ( trim($linecont) == trim($hash) )
	                {
				// Get permissions of username specified
				$linecont = $usa[2];
				switch ( (int)trim($linecont) )
				{
					case 1: $permit = 1; break;
					case 2: $permit = 2; break;
					default: $permit = 0; break;
				}
				// If the user's name is admin
				if ( $userlower == "admin" )
				{
					$permit = 3;
					$_POST["username"] = "admin";
				}
				session_set_cookie_params(0, substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT'])));
				session_start();
				$_SESSION["userhash"] = $usersha;
				$_SESSION["expiry"] = time()+600;
				$_SESSION["usertype"] = $permit;
				setcookie("username", $_POST["username"], time()+600);
				echo "<script>window.location.replace('index.php');</script>";
	                }
			// Otherwise...
	                else
			{
				echo "<script>window.location.replace('login.html?note=2');</script>";
			}
		}
	}
	}
	}
?>

