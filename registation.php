<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("config.php");

function email_validation($str)
{
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE;
}

function password_validation($str)
{
    return (strlen($str) <= 8) ? TRUE : FALSE;
}

function checkfields($str)
{
    if (!empty($str)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

if (isset($_POST['Signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "SELECT email from users WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if (empty($userdata) && email_validation($email) && password_validation($password) && checkfields($answer)) {


        $sql = "INSERT INTO users(email,password,question,answer) VALUES('$email','$password','$question','$answer');";
        $conn->query($sql);

        header("Location: login.php");
    } else if (!empty($userdata)) {
        $message1 = "Account already exists";
    } else if (!email_validation($email)) {
        $message2 = "Enter a valid email address";
    } else if (!password_validation($password)) {
        $message3 = "Password should be longer than 8 characters";
    } else if($password != $conpassword){
        $messsage4 = "Your Password doesn't match";
    } else if (!empty($answer)) {
        $message5 = "Please write any answer";
    } else {
        $message = "Please fill all the required fields";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <div class="layout">
        <div class="form">
            <div class="main-title">
                <img src="assets/icons8-notes-60.png">
                <h1>Portal</h1>
            </div>
            <div class="intro-title">
                <h3>Welcome to Portal</h3>
                <div id="title-desc">
                    <p>Let's sign-up to your account</p>
                </div>
            </div>
            <form action="registation.php" method="post" name="signup_page">
                <div class="offset">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>
                <?php if (!empty($message1)) {
                    echo "<p>" . $message1 . "</p>";
                } ?>
                <?php if (!empty($message2)) {
                    echo "<p>" . $message2 . "</p>";
                } ?>
                <div class="offset">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($message3)) {
                    echo "<p>" . $message3 . "</p>";
                } ?>
                <div class="offset">
                    <input type="password" name="conpassword" id="conpassword" required>
                    <label for="conpassword">Retype Password</label>
                </div>
                <?php if (!empty($message4)) {
                    echo "<p>" . $message4 . "</p>";
                } ?>
                <div class="offset">
                    <select name="question" required>
                        <option>Your Nickname</option>
                        <option>Your Best Friend</option>
                        <option>Your Favourite Color</option>
                    </select>
                    <label for="username">Question</label>
                </div>
                <div class="offset">
                    <input type="text" name="answer" id="name" required>
                    <label for="answer">Answer</label>
                </div>
                <?php if (!empty($message5)) {
                    echo "<p>" . $message5 . "</p>";
                } ?>
                <?php if (!empty($message)) {
                    echo "<p>" . $message . "</p>";
                } ?>
                <div id="signButton">
                    <input type="submit" name="Signup" value="Sign Up">
                </div>
                <div class="lower">
                    <a href="login.php">Login into your account</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>