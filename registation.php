<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
function email_validation($str)
{
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE;
}

function password_validation($str)
{
    return (strlen($str) <= 8 && strlen($str) > 0) ? TRUE : FALSE;
}

$message1 = $message2 = $message3 = $message4 = $message5 = $message6 = $message7 = $message8 = "";
$email = $password = $conpassword = $question = $answer = "";

if (isset($_POST['Signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $conpassword = $_POST['conpassword'];

    $sql = "SELECT email from users WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    $errcnt = 0;

    if (!empty($user_data)) {
        $message1 = "Account already exists";
        $errcnt++;
    }
    if ($email == "") {
        $message2 = "Please enter any email address";
        $errcnt++;
    }
    if (!email_validation($email)) {
        $message3 = "Enter a valid email address";
        $errcnt++;
    }
    if ($password == "") {
        $message4 = "Please enter any password";
        $errcnt++;
    }
    if (!password_validation($password)) {
        $message5 = "Password should not be longer than 8 characters";
        $errcnt++;
    }
    if ($password == "") {
        $message6 = "Please enter any text";
        $errcnt++;
    }
    if (!($password === $conpassword)) {
        $message7 = "Your Password doesn't match";
        $errcnt++;
    }
    if ($answer == "") {
        $message8 = "Please write any answer";
        $errcnt++;
    }

    if ($errcnt == 0) {


        $sql = "INSERT INTO users(email,password,question,answer) VALUES('$email','$password','$question','$answer');";
        $conn->query($sql);

        header("Location: login.php?message=Account Created Successfully");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css" />
</head>

<?php

$isSelected[0] = $isSelected[1] = $isSelected[2] = "";

if ($question == 'Your Nickname') {
    $isSelected[0] = 'selected';
} elseif ($question == 'Your Best Friend') {
    $isSelected[1] = 'selected';
} elseif ($question == 'Your Favourite Color') {
    $isSelected[2] = 'selected';
} else {
    $isSelected[0] = $isSelected[1] = $isSelected[2] = "";
} ?>

<body>
    <div class="layout">
        <div class="form">
            <div class="main-title">
                <img src="assets/icons8-logo-96.png">
                <h1>Portal</h1>
            </div>
            <div class="intro-title">
                <h3>Welcome to Portal</h3>
                <div id="title-desc">
                    <p>Let's sign-up to your account</p>
                </div>
            </div>
            <form action="registation.php" method="post" name="signup_page">
                <?php if (!empty($message)) {
                    echo "<div class='error-box'>";
                } ?>
                <?php if (!empty($message1) || !empty($message2) || !empty($message3)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="email" name="email" id="email" <?php echo "value='$email'" ?> required>
                    <label for="email">Email</label>
                </div>
                <?php if (!empty($message1) || !empty($message2) || !empty($message3)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message1)) {
                    echo "<p>" . $message1 . "</p>";
                } ?>
                <?php if (!empty($message2) && empty($message3)) {
                    echo "<p>" . $message2 . "</p>";
                } ?>
                <?php if (!empty($message3)) {
                    echo "<p>" . $message3 . "</p>";
                } ?>
                <?php if (!empty($message4) || !empty($message5) || !empty($message7)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="password" name="password" id="password" <?php echo "value='$password'" ?>required>
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($message4) || !empty($message5) || !empty($message7)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message4)) {
                    echo "<p>" . $message4 . "</p>";
                } ?>
                <?php if (!empty($message6) || !empty($message7)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="password" name="conpassword" id="conpassword" <?php echo "value='$conpassword'" ?>required>
                    <label for="conpassword">Retype Password</label>
                </div>
                <?php if (!empty($message6) || !empty($message7)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message6)) {
                    echo "<p>" . $message6 . "</p>";
                } ?>
                <?php if (!empty($message7)) {
                    echo "<p>" . $message7 . "</p>";
                } ?>
                <div class="offset">
                    <select name="question" required>
                        <option <?php echo $isSelected[0]; ?>>Your Nickname</option>
                        <option <?php echo $isSelected[1]; ?>>Your Best Friend</option>
                        <option <?php echo $isSelected[2]; ?>>Your Favourite Color</option>
                    </select>
                    <label for="username">Question</label>
                </div>
                <?php if (!empty($message8)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="text" name="answer" id="name" <?php echo "value='$answer'" ?>required>
                    <label for="answer">Answer</label>
                </div>
                <?php if (!empty($message8)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message8)) {
                    echo "<p>" . $message8 . "</p>";
                } ?>
                <?php if (!empty($message)) {
                    echo "</div>";
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