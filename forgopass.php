<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");

if (isset($_POST['Recover'])) {
    $email = $_POST['email'];

    $message1 = $message2 = "";

    $sql = "SELECT uid,email FROM users WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
    $id = $user_data['uid'];
    if (!empty($email)) {
        if ($user_data['email'] == $email) {
            header("Location: resetpass.php?id=$id");
        } else {
            $message1 = "Email Address doesn't exists!";
        }
    } else {
        $message2 = "Please enter an email";
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
    <div class="layout">
        <div class="form">
            <div class="main-title">
                <img src="assets/icons8-logo-96.png">
                <h1>Portal</h1>
            </div>
            <div class="intro-title">
                <h3>Welcome to Portal</h3>
                <div id="title-desc">
                    <p>Recover your account</p>
                </div>
            </div>
            <form action="forgopass.php" method="post" name="forgopass_page">
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
                <?php if (!empty($message2) && empty($message1)) {
                    echo "<p>" . $message2 . "</p>";
                } ?>
                <div id="signButton">
                    <input type="submit" name="Recover" value="Recover">
                </div>
                <div class="lower">
                    <a href="login.php" id="reglink">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>