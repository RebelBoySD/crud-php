<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
require("auth_session.php");

$errcnt = 0;
$name = $email = $gender = $address = $city = $state = $newsletter = "";
function email_validation($str)
{
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE;
}

if (isset($_POST['Update'])) {
    $id = $_POST['id'];
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
        $errcnt++;
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
        $sql = "UPDATE employees SET name='$name',email='$email',gender='$gender',address='$address',city='$city',state='$state',newsletter='$newsletter' WHERE id=$id;";
        $conn->query($sql);
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Details</title>
    <link rel="stylesheet" href="form.css">
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
    <?php

    $id = $_REQUEST['id'];
    $sql = "SELECT id,name,email,gender,address,city,state,newsletter from employees WHERE id = $id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if ($errcnt == 0) {
        $id = $user_data['id'];
        $name = $user_data['name'];
        $email = $user_data['email'];
        $gender = $user_data['gender'];
        $address = $user_data['address'];
        $city = $user_data['city'];
        $state = $user_data['state'];
        $newsletter = $user_data['newsletter'];
        if ($newsletter == "yes") {
            $newsletter = 1;
        } else {
            $newsletter = 0;
        }
    }

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
    <article>
        <div class="topSection">
            <h1>Edit Details</h1>
            <div class="top-components">
                <a href="index.php"><button id="backButton">Back</button></a>
            </div>
        </div>
        <div class="layout">
            <div class="form">
                <form name="edit_page" method="post" action="update.php">
                    <?php if (!empty($message1)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="name">Name</label><input type="text" name="name" value="<?php echo $name; ?>" required>
                    <?php if (!empty($message1)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message1)) {
                        echo "<p>" . $message1 . "</p>";
                    } ?>
                    <?php if (!empty($message2) || !empty($message3)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="email">Email</label><input type="email" name="email" value="<?php echo $email; ?>"
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
                    <div class="same-line"><label for="gender">Gender</label>
                        <input type="radio" name="gender" value="Male" <?php echo $isMale; ?>>
                        <label for="Male">Male</label>
                        <input type="radio" name="gender" value="Female" <?php echo $isFemale; ?>>
                        <label for="Female">Female</label>
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
                    <label for="address">Address</label><textarea name="address"><?php echo $address; ?></textarea>
                    <?php if (!empty($message5)) {
                        echo "</div>";
                    } ?>
                    <?php if (!empty($message5)) {
                        echo "<p>" . $message5 . "</p>";
                    } ?>
                    <?php if (!empty($message6)) {
                        echo "<div class='error-box'>";
                    } ?>
                    <label for="city">City</label><input type="text" name="city" value="<?php echo $city; ?>">
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
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
                    <input type="submit" name="Update" value="Update" id="addButton">
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