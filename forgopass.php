<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
if (isset($_POST['Find'])) {
    $email = $_POST['email'];

    $sql = "SELECT id,email FROM employees WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
    $id = $user_data['id'];
    if ($user_data['email'] == $email) {
        header("Location: resetpass.php?id=$id");
    } else {
        $message = "Email Address doesn't exists!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forget Password</title>
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
                    <p>Recover your account</p>
                </div>
                <form action="forgopass.php" method="post" name="forgopass_page">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <?php if(!empty($message)){echo "<p>" . $message . "</p>";} ?>
                    <input type="submit" name="Find" value="Find">
                    <a href="registation.php" id="reglink">Sign Up</a>
                    <a href="login.php" id="reglink">Login</a>
                </form>
            </div>
        </div>
    </article>
    <footer>
        <h3>Address</h3>
        <p>#31, Oxford Street, London East, Main City, London, United Kingdown</p>
        <p>Copyright &#169; 2023</p>
    </footer>
</body>

</html>