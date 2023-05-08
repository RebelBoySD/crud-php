<?php

include_once("config.php");

session_start();
if ($_SESSION["LoggedIn"] != "yes") {
   header('Location:login.php');
}

$id = $_GET['id'];

$sql = "DELETE from employees WHERE id =$id";
$conn->query($sql);

header("Location:index.php");
?>