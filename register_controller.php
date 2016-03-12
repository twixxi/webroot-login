<?php
$errors = "";
$registered = false;
do if (isset($_POST['subreg'])) {
	if (!isset($_POST['username'])) $errors .= "Please choose a username.<br />";
	if (!isset($_POST['pass1'])) $errors .= "Please choose a password.<br />";
	if (!isset($_POST['pass2'])) $errors .= "Please repeat your password.<br />";
	if ($errors<>"") break;
	if (strlen($_POST['pass1'])<6) $errors .= "Please choose a password that is 6 or more characters.<br />";
	if ($_POST['pass1']<>$_POST['pass2']) $errors .= "Your passwords do not match.<br />";
	$username = ucwords(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
	$query = "select username from users where username = '$username' limit 1";
	$res = $db->query($query);
	if ($res->num_rows == 1) $errors .= "This username is already taken, please choose another.<br />";
	if ($errors<>"") break;
	$passhash = password_hash($_POST['pass1'], PASSWORD_BCRYPT);
	$query = "insert into users (username, passhash) values ('$username', '$passhash')";
	$db->query($query);

	$registered = true;
} while (false);