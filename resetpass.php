<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");

function password_validation($str)
{
    return (strlen($str) <= 8) ? TRUE : FALSE;
}

if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
    header("Location: forgopass.php");
}

$message1 = $message2 = $message3 = $message4 =  $message5 = $message6 = "";
$email = $password = $conpassword = $question = $answer = "";

if (isset($_POST['Reset'])) {
    $id = $_POST['id'];
    $password1 = $_POST['password'];
    $conpassword = $_POST['conpassword'];
    $answer = $_POST['answer'];

    $sql = "SELECT answer from users WHERE uid='$id';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    $errcnt = 0;

    if ($answer == "") {
        $message1 = "Please answer the question";
        $errcnt++;
    }
    if ($password == "") {
        $message3 = "Please enter any text";
        $errcnt++;
    }
    if(!password_validation($password)){
        $message4 = "Password should be longer than 8 characters";
        $errcnt++;
    }
    if ($conpassword == "") {
        $message5 = "Please enter any text";
        $errcnt++;
    }
    if(!($password === $conpassword)){
        $message6 = "Your Password doesn't match";
        $errcnt++;
    } 
    if ($user_data['answer'] === $answer && $errcnt == 0) {
        $sql = "UPDATE users SET password = '$password' WHERE uid ='$id';";
        $conn->query($sql);
        header("Location: login.php");
    } else{
        $message2 == "Wrong Answer";
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
$id = $_REQUEST['id'];
$sql = "SELECT question from users WHERE uid='$id';";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();

$isSelected[0] = $isSelected[1] = $isSelected[2] = "";

if ($question == 'Your Nickname') {
    $isSelected[0] = 'selected';
} elseif ($question == 'Your Best Friend') {
    $isSelected[1] = 'selected';
} elseif ($question == 'Your Favourite Color') {
    $isSelected[2] = 'selected';
}else {
    $isSelected[0] = $isSelected[1] = $isSelected[2] = "";
}

?>

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
                    <p>Reset Your Password by answering question</p>
                </div>
            </div>
            <form action="resetpass.php" method="post" name="resetpass_page">
            <?php if (!empty($message1) || !empty($message2)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="text" name="answer" id="answer" <?php echo "value='$answer'"?>required>
                    <label for="question">
                        <?php echo $user_data['question']; ?> ?
                    </label>
                </div>
                <?php if (!empty($message1) || !empty($message2)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message3) || !empty($message4)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="password" name="password" id="password" <?php echo "value='$password'"?>required>
                    <label for="password">New Password</label>
                    </label>
                </div>
                <?php if (!empty($message3) || !empty($message4)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message3)) {
                    echo "<p>" . $message3 . "</p>";
                } ?>
                <?php if (!empty($message4)) {
                    echo "<p>" . $message4 . "</p>";
                } ?>
                <?php if (!empty($message5) || !empty($message6)) {
                    echo "<div class='error-box'>";
                } ?>
                <div class="offset">
                    <input type="password" name="conpassword" id="conpassword" <?php echo "value='$conpassword'"?>required>
                    <label for="conpassword">Retype New Password</label>
                    </label>
                </div>
                <?php if (!empty($message5) || !empty($message6)) {
                    echo "</div>";
                } ?>
                <?php if (!empty($message5)) {
                    echo "<p>" . $message5 . "</p>";
                } ?>
                <?php if (!empty($message6)) {
                    echo "<p>" . $message6 . "</p>";
                } ?>
                <input type="hidden" name="id" value= "<?php echo $_REQUEST['id']; ?>" >
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