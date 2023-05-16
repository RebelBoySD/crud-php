<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
require("auth_session.php");

session_start();
if ($_SESSION["LoggedIn"] == "yes") {
    header('Location:index.php');
}

$message1 = $message2 = $message3 = $message4 = "";
$email = $password = $conpassword = $question = $answer = "";

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberme = $_POST['rememberuser'];

    $sql = "SELECT email,password from users WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    $errcnt = 0;
    if ($user_data['email'] !== $email) {
        $message1 = "Email Address doesn't exists!";
        $errcnt++;
        if ($email == "") {
            $message2 = "Please enter an email";
            $errcnt++;
        }
    }
    if ($user_data['password'] !== $password) {
        $message3 = "Wrong Password";
        $errcnt++;
        if ($password == "") {
            $message4 = "Please enter a password";
            $errcnt++;
        }
    }
    if ($errcnt == 0) {
        session_start();
        $_SESSION["LoggedIn"] = "yes";

        if($rememberme == 'yes'){
            $cookie_name = "rememberuser";
            $cookie_value = "yes";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 7));
        }

        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
</head>

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
                    <p>Please log-in to your account</p>
                </div>
            </div>
            <?php
                if(isset($_GET['message'])){
                $message = $_GET['message'];
                echo "<div id='message'><p>$message</p></div>";
                } 
            ?>
            <form action="login.php" method="post" name="login_page">
                <?php if (!empty($message1) || !empty($message2)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="email" name="email" id="email" <?php echo "value='$email'" ?>required>
                    <label for="email">Email</label>
                </div>
                <?php if (!empty($message1) || !empty($message2)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message1) && empty($message2)) {
                    echo "<p>" . $message1 . "</p>";
                } ?>
                <?php if (!empty($message2)) {
                    echo "<p>" . $message2 . "</p>";
                } ?>
                <?php if (!empty($message3) || !empty($message4)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="password" name="password" id="password" <?php echo "value='$password'" ?>required>
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($message3) || !empty($message4)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message3) && empty($message4)) {
                    echo "<p>" . $message3 . "</p>";
                } ?>
                <?php if (!empty($message4)) {
                    echo "<p>" . $message4 . "</p>";
                } ?>
                <div class="linksection">
                <span class="rememberme"><label for="rememberme">Remember Me</label>
                <input type="checkbox" name="rememberuser" value="yes"></span>
                <a href="forgopass.php">Forgot Password?</a>
                </div>
                <input type="submit" name="Login" value="Login">
                <div class="lower">
                    <p>New on our platform?</p><a href="registation.php" id="reglink"> Create an account</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>