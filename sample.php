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

1. Reset Password (Url Method)
forgopass.php

$green = uniqid(rand());
$token = substr($green, 0, 8);

$sql = "UPDATE users SET token = '$token' WHERE uid = '$id';"

resetpass.php

$token = $_GET['token'];
$sql ='SELECT uid FROM users WHERE token = $token;'
$conn->query($sql);

if(empty(userdata['id]'')){
    header("Location: forgopass.php);
}

$sql ='DELETE token FROM users WHERE uid = $id;'
$conn->query($sql);

States Table

index.php

$sql = Select state FROM states;
$conn->query($sql);

do(
    echo "<option value='$user_data["state"]'>$user_data['state']</option>";
)
while($user_data = $result->fetch_assoc());