<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");

session_start();
if ($_SESSION["LoggedIn"] == "yes") {
    header('Location:index.php');
}

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT email,password from users WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if ($user_data['email'] === $email && $user_data['password'] === $password) {
        session_start();
        $_SESSION["LoggedIn"] = "yes";
        header("Location: index.php");
    } elseif ($user_data['email'] != $email) {
        $message1 = "Email Address doesn't exists!";
    } elseif ($user_data['password'] != $password) {
        $message2 = "Wrong Password";
    } else {
        header("Location: login.php");
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
                <img src="assets/icons8-notes-60.png">
                <h1>Portal</h1>
            </div>
            <div class="intro-title">
                <h3>Welcome to Portal</h3>
                <div id="title-desc">
                    <p>Please log-in to your account</p>
                </div>
            </div>
            <form action="login.php" method="post" name="login_page">
                <div class="offset" >
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>
                <?php if (!empty($message1)) {
                    echo "<p>" . $message1 . "</p>";
                } ?>
                <div class="offset" >
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <?php if (!empty($message2)) {
                    echo "<p>" . $message2 . "</p>";
                } ?>
                <div class="linksection">
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