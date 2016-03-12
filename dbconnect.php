<?php
$sqlusername = "root";
$sqlpassword = "password";
$sqlhostname = "localhost";
$db = new mysqli($sqlhostname, $sqlusername, $sqlpassword, "stuff");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
}
?>