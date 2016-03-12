<h1>Register an account</h1>
<?php 
if ($registered) echo "Welcome $username, you are now registered and can log in. <a href='index.php'>Return to the home page</a>.";
else {
	if ($errors<>"") echo "<font color=red>$errors</font>"; ?>
	<form method="POST">
	Enter a username: <input name = "username" required><br />
	Choose a password: <input name = "pass1" type="password" required> (must be at least 6 characters)<br />
	Repeat your password: <input name = "pass2" type="password" required><br />
	<input type="submit" name="subreg" value="Register">




<?php
}
?>