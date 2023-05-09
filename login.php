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

    $sql = "SELECT email,password from employees WHERE email='$email';";
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
    <header>
        <img src="assets/icons8-lock-50 (1).png">
        <h1><a href="index.php">Keep Safe</a></h1>
    </header>
    <article>
        <div class="layout">
            <div class="form">
                <div class="main-title">
                    <h1>Portal</h1>
                </div>
                <div class="intro-title">
                    <h3>Welcome to Portal</h3>
                    <p>Please log-in to your account</p>
                </div>
                <form action="login.php" method="post" name="login_page">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <?php if(!empty($message1)){echo "<p>" . $message1 . "</p>";} ?>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <?php if(!empty($message2)){echo "<p>" . $message2 . "</p>";} ?>
                    <div class="linksection">
                        <a href="forgopass.php">Forgot Password</a>
                    </div>
                    <input type="submit" name="Login" value="Login">
                    <a href="registation.php" id="reglink">Create an account</a>
                </form>
            </div>
        </div>
    </article>
    <footer>
        <h3>Address</h3>
        <p>#31, Oxford Street, London East, Main City, London, United Kingdom</p>
        <p>Copyright &#169; 2023</p>
    </footer>
</body>

</html>