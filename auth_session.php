<?php
include_once("config.php");

session_start();
if ($_SESSION["LoggedIn"] != "yes") {
    header('Location:login.php');
}
?>