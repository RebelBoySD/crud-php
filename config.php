<?php

$servername = "localhost";
$username = "debian-sys-maint";
$password = "Qtm0UY6XWhsk6dC9";
$databasename = "sagar";

$conn = new mysqli($servername, $username, $password, $databasename);
if (!$conn) {
	echo "Failed";
}

?>