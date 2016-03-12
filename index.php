<?php
include ("dbconnect.php");
$loggedin = false;
$loggedout = false;

if (isset($_POST['sublogout'])) {
	setcookie('username','/', time()-3600);
	setcookie('passhash','/', time()-3600);	
	$loggedout = true;
}

// ************** LOGIN FORM SUBMITTED *******************
do if (!$loggedout && isset($_POST['sublogin'])) { 
	if($_POST['username']==""||$_POST['pass']=="") {
		echo "<font color='red'>Error: Username or password are invalid</font><br />";
		break;
	}
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$query = "select passhash from users where username = '$username' limit 1";
	$res = $db->query($query);
	if ($res) {
		$row = $res->fetch_assoc();
		if (password_verify($_POST['pass'], $row['passhash'])) {
			setcookie('username', $username);
			setcookie('passhash', $row['passhash']);
			$loggedin = true;
			break;
		} else {
			echo "<font color='red'>Error: Username or password are invalid</font><br />";
			break;
		}
	} else {
		echo "<font color='red'>Error: Username or password are invalid</font><br />";
		break;
	}

} while (false);
// ************** END OF LOGIN FORM SUBMITTED *******************


// ************** CHECK IF USER IS LOGGED IN *******************
do if (!$loggedin && !$loggedout && (isset($_COOKIE['passhash']) && isset($_COOKIE['username']))) { //User is already logged in
	$username = filter_var($_COOKIE['username'], FILTER_SANITIZE_STRING);
	$passhash = filter_var($_COOKIE['passhash'], FILTER_SANITIZE_STRING);
	$query = "select username from users where username = '$username' and passhash = '$passhash' limit 1";
	$res = $db->query($query);
	if ($res->num_rows==1) {
		$loggedin = true;
		break;
	}
	echo "THIS IS WHAT IS GOING WRONG";
	// Cookie is invalid, DESTROY IT!!!
	setcookie('username','/', time()-3600);
	setcookie('passhash','/', time()-3600);
} while (false);
// *************** END OF USER LOGGED IN CHECK *****************

if (isset($username)) $username = ucwords($username);

if (!$loggedin) { // Display the login form
	?>
	<form method="POST">
	Username: <input name='username' required> Password: <input name='pass' type='password' required> <input type="submit" name="sublogin" value="Login"> Don't have an account? <a href='index.php?p=register'>Register here</a></form>
	<?php
} else { // User is logged in
	echo "<form method='POST'>Welcome $username! <input type='submit' name='sublogout' value='Logout' style='float:right'></form></div>";
}

?>
<hr />

<?php 
if (isset($_REQUEST['p'])) {
	$p = filter_var($_REQUEST['p'],FILTER_SANITIZE_STRING);
	if (($p!="index.php") && file_exists($p.".php")) {
			include ($p."_controller.php");
			include ($p.".php");
		}
		else include('404.php');
}
else include('loremipsum.php'); // Home page
?>







<?php
include ("dbdisconnect.php"); 
?>