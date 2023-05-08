<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("config.php");
require("auth_session.php");

if (isset($_POST['Create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $newsletter = $_POST['newsletter'];
    if ($newsletter == "yes") {
        $newsletter = 1;
    } else {
        $newsletter = 0;
    }

    // var_dump($gender);
    // var_dump($newsletter);
    // die();
    $sql = "SELECT email FROM employees WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
    // var_dump($name);
    // var_dump($user_data['email']);
    // var_dump($email);
    // die();
    if ($user_data['email'] == $email) {
        $message = "No email address can be used twice";

    } else {
        $sql = "INSERT INTO employees(name,email,gender,address,city,state,newsletter,created_at) VALUES('$name','$email','$gender','$address','$city','$state','$newsletter',NOW());";
        $conn->query($sql);

        header("Location:index.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Page</title>
    <link rel="stylesheet" href="form.css" />
</head>

<body>
    <header>
        <img src="assets/icons8-lock-50 (1).png">
        <h1>Keep Safe</h1>
    </header>
    <article>
        <div class="topSection">
            <h1>Add Details</h1>
            <div class="top-components">
                <a href="logout.php"><button id="logoutButton">Log out</button></a>
                <a href="index.php"><button id="backButton">Back</button></a>
            </div>
        </div>
        <div class="layout">
            <div class="form">
                <form action="create.php" name="create_page" method="post">
                    <label for="name">Name</label><input type="text" name="name" required>
                    <label for="email">Email</label><input type="text" name="email" required>
                    <?php if (!empty($message)) {
                        echo "<p>" . $message . "</p>";
                    } ?>
                    <div class="same-line">
                        <label for="gender">Gender</label>
                        <input type="radio" name="gender" value="male" required>
                        <label for="Male" class="notreq">Male</label>
                        <input type="radio" name="gender" value="female">
                        <label for="Female" class="notreq">Female</label>
                    </div>
                    <label for="address">Address</label><input type="text" name="address">
                    <label for="city">City</label><input type="text" name="city">
                    <label for="state">State</label>
                    <select name="state">
                        <option value="Haryana">Haryana</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Maharasta">Maharasta</option>
                    </select>
                    <div class="same-line">
                        <label for="newsletter">Newsletter</label>
                        <input type="checkbox" name="newsletter" value="yes">
                    </div>
                    <input type="submit" name="Create" value="Create" id="addButton">
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