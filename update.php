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
    } else if (empty($email) || !email_validation($email)) {
        $message2 = "Please enter the email";
    } else if (empty($gender)) {
        $message3 = "Please select the gender";
    } else {
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
        <img src="assets/icons8-lock-50 (1).png">
        <h1><a href="index.php">Keep Safe</a></h1>
    </header>
    <?php

    $id = $_REQUEST['id'];
    $sql = "SELECT id,name,email,gender,address,city,state,newsletter from employees WHERE id = $id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    if ($user_data['gender'] == "Male") {
        $isMale = 'checked';
    } else {
        $isFemale = 'checked';
    }

    if ($user_data['newsletter'] == 1) {
        $isOpted = 'checked';
    }

    if ($user_data['state'] == "Haryana") {
        $isSelected[0] = 'selected';
    } elseif ($user_data['state'] == 'Punjab') {
        $isSelected[1] = 'selected';
    } elseif ($user_data['state'] == 'Gujarat') {
        $isSelected[2] = 'selected';
    } else {
        $isSelected[3] = 'selected';
    }
    ?>
    <article>
        <div class="topSection">
            <h1>Edit Details</h1>
            <div class="top-components">
                <a href="logout.php"><img src="assets/icons8-logout-30.png"></a>
                <a href="index.php"><img src="assets/icons8-go-back-24.png"></a>
            </div>
        </div>
        <div class="layout">
            <div class="form">
                <form name="edit_page" method="post" action="update.php">
                    <label for="name">Name</label><input type="text" name="name"
                        value="<?php echo $user_data['name']; ?>" required>
                    <?php if (!empty($message1)) {
                        echo "<p>" . $message1 . "</p>";
                    } ?>
                    <label for="email">Email</label><input type="email" name="email"
                        value="<?php echo $user_data['email']; ?>" required>
                    <?php if (!empty($message2)) {
                        echo "<p>" . $message2 . "</p>";
                    } ?>
                    <div class="same-line"><label for="gender">Gender</label>
                        <input type="radio" name="gender" value="Male" <?php echo $isMale; ?>>
                        <label for="Male">Male</label>
                        <input type="radio" name="gender" value="Female" <?php echo $isFemale; ?>>
                        <label for="Female">Female</label>
                    </div>
                    <?php if (!empty($message3)) {
                        echo "<p>" . $message3 . "</p>";
                    } ?>
                    <label for="address">Address</label><textarea
                        name="address"><?php echo $user_data['address']; ?></textarea>
                    <label for="city">City</label><input type="text" name="city"
                        value="<?php echo $user_data['city']; ?>">
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
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
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