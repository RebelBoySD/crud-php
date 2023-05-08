<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("config.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: forgopass.php");
} else {
    if (isset($_POST['Reset'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $answer = $_POST['answer'];

        $sql = "SELECT answer from employees WHERE id='$id';";
        $result = $conn->query($sql);
        $user_data = $result->fetch_assoc();
        if ($user_data['answer'] == $answer) {
            $sql = "UPDATE employees SET password = '$password' WHERE id ='$id';";
            $conn->query($sql);
            header("Location: login.php");
        } else {
            header("Location: resetpass.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css" />
</head>
<?php
$id = $_GET['id'];
$sql = "SELECT question from employees WHERE id='$id';";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();
?>

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
                    <p>Reset Your Password by answering question</p>
                </div>
                <form action="resetpass.php" method="post" name="resetpass_page">
                    <label for="question">
                        <strong>
                            <?php echo $user_data['question']; ?> ?
                        </strong>
                    </label>
                    <input type="text" name="answer" id="answer" required>
                    <label for="password">New Password</label>
                    <input type="text" name="password" id="password" required>
                    </label>
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <input type="submit" name="Reset" value="Reset Password">
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