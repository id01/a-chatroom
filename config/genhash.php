<html><body>
<?php
	if (isset($_POST["password"]))
	{
		echo "Your admin hash is: " . hash('sha256', crypt($_POST["password"], 'admin'));
	}
	else
	{
		echo "<form method='post' action='genhash.php'>";
		echo "Password: <input type='text' name='password'>";
		echo "<input type='submit' value='Hash it!'>";
		echo "</form>";
	}
?>
</body></html>
