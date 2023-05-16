<?php
include_once("config.php");

session_start();
if($_COOKIE["rememberuser"] == "yes"){
    session_start();
    $_SESSION["LoggedIn"] = "yes";
}

if ($_SESSION["LoggedIn"] != "yes") {
    header('Location:login.php');
}
?>