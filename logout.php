<?php
session_start();
include_once("config.php");
if (session_destroy()) {
    header("Location: login.php");
}
?>