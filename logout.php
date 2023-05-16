<?php
session_start();
include_once("config.php");
setcookie("rememberuser", "", time() - 3600);
if (session_destroy()) {
    header("Location: login.php");
}
?>