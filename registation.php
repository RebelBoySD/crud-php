<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
if (isset($_POST['Signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "SELECT email from employees WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if (empty($userdata)) {

        $sql = "INSERT INTO employees(name,password,question,answer,created_at) VALUES('$email','$password','$question','$answer',NOW());";
        $conn->query($sql);

        header("Location: login.php");
    } else {
        $message = "Account already exists";
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
    <header>
        <img src="assets/icons8-lock-50 (1).png">
        <h1>Keep Safe</h1>
    </header>
    <article>
        <div class="layout">
            <div class="form">
                <div class="main-title">
                    <h1>Portal</h1>
                </div>
                <div class="intro-title">
                    <h3>Welcome to Portal</h3>
                    <p>Let's sign-up to your account</p>
                </div>
                <form action="registation.php" method="post" name="signup_page">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <?php if(!empty($message)){echo "<p>" . $message . "</p>";} ?>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <label for="username">Question</label>
                    <select name="question" required>
                        <option>Your Nickname</option>
                        <option>Your Best Friend</option>
                        <option>Your Favourite Color</option>
                    </select>
                    <label for="answer">Answer</label>
                    <input type="text" name="answer" id="name" required>
                    <input type="submit" name="Signup" value="Sign Up">
                    <a href="login.php" id="reglink">Login into your account</a>
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