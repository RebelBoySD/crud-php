<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $green = uniqid(rand());
    echo $green . " ". strlen($green). " ";
    $token = substr($green, 0, 8);
    echo $token. " ".strlen($token). " ";

    var_dump(mail("sagardolia@gmail.com","Random Token", $token, "From: hello@yahoobaba.net")); 
    var_dump($_COOKIE["rememberuser"]);
?>

$random = uniqid(rand());
            $cookie_value = substr($random, 0, 8);