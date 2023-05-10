<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");

function password_validation($str)
{
    return (strlen($str) <= 8) ? TRUE : FALSE;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: forgopass.php");
}
if (isset($_POST['Reset'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];
    $answer = $_POST['answer'];

    $sql = "SELECT answer from users WHERE uid='$id';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if(!password_validation($password) && !password_validation($conpassword)){
        $message = "Password should be longer than 8 characters";
    } else if($password != $conpassword){
        $messsage1 = "Your Password doesn't match";
    } else if ($user_data['answer'] === $answer) {
        $sql = "UPDATE users SET password = '$password' WHERE uid ='$id';";
        $conn->query($sql);
        header("Location: login.php");
    }else {
        header("Location: resetpass.php");
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
$sql = "SELECT question from users WHERE uid='$id';";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();
?>

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
                    <p>Reset Your Password by answering question</p>
                </div>
            </div>
            <form action="resetpass.php" method="post" name="resetpass_page">
                <div class="offset">
                    <input type="text" name="answer" id="answer" required>
                    <label for="question">
                        <?php echo $user_data['question']; ?> ?
                    </label>
                </div>
                <div class="offset">
                    <input type="password" name="password" id="password" required>
                    <label for="password">New Password</label>
                    </label>
                </div>
                <?php if (!empty($message)) {
                    echo "<p>" . $message . "</p>";
                } ?>
                <div class="offset">
                    <input type="password" name="conpassword" id="conpassword" required>
                    <label for="conpassword">Retype New Password</label>
                    </label>
                </div>
                <?php if (!empty($message1)) {
                    echo "<p>" . $message1 . "</p>";
                } ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div id="signButton">
                    <input type="submit" name="Reset" value="Reset Password">
                </div>
                <div class="lower">
                    <a href="login.php" id="reglink">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>