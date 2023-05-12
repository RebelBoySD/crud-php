<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
require("auth_session.php");

function email_validation($str)
{
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE;
}

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

    $sql = "SELECT email FROM employees WHERE email='$email';";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    $errcnt = 0;
    if (empty($name)) {
        $message1 = "Please enter the name";
        $errcnt++;
    }
    if (empty($email)) {
        $message2 = "Please enter the email";
        $errcnt++;
    }
    if (!email_validation($email)) {
        $message3 = "Please enter a valid email";
        $errcnt++;
    }
    if (empty($gender)) {
        $message4 = "Please select the gender";
    }
    if (empty($address)) {
        $message5 = "Please enter the address";
        $errcnt++;
    }
    if (empty($city)) {
        $message6 = "Please enter the city";
        $errcnt++;
    }
    if ($errcnt == 0) {
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
        <div class="logo">
            <img src="assets/icons8-lock-50 (1).png">
            <h1><a href="index.php">Keep Safe</a></h1>
        </div>
        <div class="logoButton">
            <!-- <a href="account.php"><img src="assets/icons8-male-user-96.png"></a> -->
            <a href="logout.php"><img src="assets/icons8-logout-30.png"></a>
        </div>
    </header>
    <article>
        <div class="topSection">
            <h1>Add Details</h1>
            <div class="top-components">
                <a href="index.php"><button id="backButton">Back</button></a>
            </div>
        </div>
        <div class="layout">
            <div class="form">
                <form action="create.php" name="create_page" method="post">
                    <?php
                    if ($gender === "Male") {
                        $isMale = 'checked';
                    }
                    if ($gender === "Female") {
                        $isFemale = 'checked';
                    }

                    if ($newsletter == 1) {
                        $isOpted = 'checked';
                    }

                    if ($state == "Haryana") {
                        $isSelected[0] = 'selected';
                    } elseif ($state == 'Punjab') {
                        $isSelected[1] = 'selected';
                    } elseif ($state == 'Gujarat') {
                        $isSelected[2] = 'selected';
                    } else {
                        $isSelected[3] = 'selected';
                    }
                    ?>
                    <?php if (!empty($message1)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="name">Name</label><input type="text" name="name" <?php echo "value='$name'" ?> required>
                    <?php if (!empty($message1)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message1)) {
                        echo "<p>" . $message1 . "</p>";
                    } ?>
                    <?php if (!empty($message2) || !empty($message3)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="email">Email</label><input type="email" name="email" <?php echo "value='$email'" ?>
                        required>
                    <?php if (!empty($message2) || !empty($message3)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message2)) {
                        echo "<p>" . $message2 . "</p>";
                    } ?>
                    <?php if (!empty($message3) && empty($message2)) {
                        echo "<p>" . $message3 . "</p>";
                    } ?>
                    <?php if (!empty($message4)) {
                        echo "<div class='radio-error'>";
                    } ?>
                    <div class="same-line">
                        <label for="gender">Gender</label>
                        <input type="radio" name="gender" value="male" <?php echo $isMale; ?>required>
                        <label for="Male" class="notreq">Male</label>
                        <input type="radio" name="gender" value="female" <?php echo $isFemale; ?>>
                        <label for="Female" class="notreq">Female</label>
                    </div>
                    <?php if (!empty($message4)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message4)) {
                        echo "<p>" . $message4 . "</p>";
                    } ?>
                    <?php if (!empty($message5)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="address">Address</label><textarea name="address" <?php echo "value='$address'" ?>></textarea>
                    <?php if (!empty($message5)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message5)) {
                        echo "<p>" . $message5 . "</p>";
                    } ?>
                    <?php if (!empty($message6)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="city">City</label><input type="text" name="city" <?php echo "value='$city'" ?>>
                    <?php if (!empty($message6)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message6)) {
                        echo "<p>" . $message6 . "</p>";
                    } ?>
                    <label for="state">State</label>
                    <select name="state">
                        <option value="Haryana" <?php echo $isSelected[0]; ?>>Haryana</option>
                        <option value="Punjab" <?php echo $isSelected[1]; ?>>Punjab</option>
                        <option value="Gujarat" <?php echo $isSelected[2]; ?>>Gujarat</option>
                        <option value="Maharasta" <?php echo $isSelected[3]; ?>>Maharasta</option>
                    </select>
                    <div class="same-line">
                        <label for="newsletter">Newsletter</label>
                        <input type="checkbox" name="newsletter" value="yes" <?php echo $isOpted; ?>>
                    </div>
                    <input type="submit" name="Create" value="Create" id="addButton">
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