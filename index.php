<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once("config.php");
require("auth_session.php");

if (isset($_POST['Search'])) {
	$searchedText = $_POST['searchedText'];
	if ($searchedText == "") {
		$searchflag = 1;
	} else {
		$sql = "SELECT id,name,email,gender,address,city,state,newsletter from employees WHERE name LIKE '%$searchedText%' OR email LIKE '%$searchedText%' OR gender LIKE '%$searchedText%' OR address LIKE '%$searchedText%' OR city LIKE '%$searchedText%' OR state LIKE '%$searchedText%';";
		$result = $conn->query($sql);
		$user_data = $result->fetch_assoc();
		if (empty($user_data)) {
			$searchflag = 1;
		}
	}
} else {
	$sql = "SELECT COUNT(*) FROM employees";
	$result = $conn->query($sql);
	$user_data = $result->fetch_assoc();
	$entries = $user_data["COUNT(*)"];
	$entriesperpage = 5;
	$currentpage = 1;
	$lastpage = $entries / $entriesperpage;
	if ($entries % $entriesperpage != 0) {
		$lastpage = round($lastpage, 0, PHP_ROUND_HALF_UP) + 1;
	}
	if (empty($_GET['page'])) {
		$currentpage = 1;
	} else if (isset($_GET['page'])) {
		$currentpage = $_GET['page'];
	}
	$previouspage = ($currentpage > 1) ? ($currentpage - 1) : $currentpage;
	$nextpage = ($currentpage == $lastpage) ? $currentpage : ($currentpage + 1);
	$lastentry = ($currentpage - 1) * $entriesperpage;
	$sql = "SELECT id,name,email,gender,address,city,state,newsletter from employees ORDER BY modified_at DESC LIMIT $entriesperpage OFFSET $lastentry";
	$result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Employees Details</title>
	<link rel="stylesheet" href="tables.css" />
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
		<div class="topsection">
			<h1>Employees Details</h1>
			<div class="top-components">
				<div class="container">
					<form action="index.php" method="post">
						<input type="search" placeholder="Search" name="searchedText">
						<button type="submit" name="Search">Search</button>
					</form>
				</div>
				<a href="create.php"><button id="addButton">Add</button></a>
			</div>
		</div>
		<?php
		if (empty($searchflag)) {
			echo "<table>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Newsletter</th>
				<th>Action</th>
			</tr>";
			do {
				if ($user_data['newsletter'] == 1) {
					$newsletter = "Yes";
				} else {
					$newsletter = "No";
				}
				if (empty($user_data['name'])) {
					continue;
				}
				echo "<tr>";
				echo "<td>" . $user_data['name'] . "</td>";
				echo "<td>" . $user_data['email'] . "</td>";
				echo "<td>" . $user_data['gender'] . "</td>";
				echo "<td>" . $user_data['address'] . "</td>";
				echo "<td>" . $user_data['city'] . "</td>";
				echo "<td>" . $user_data['state'] . "</td>";
				echo "<td>" . $newsletter . "</td>";
				echo "<td><a href='update.php?id=" . $user_data['id'] . "'><img src='assets/icons8-edit-30.png'></a><a href='delete.php?id=" . $user_data['id'] . "'><img src='assets/icons8-delete-24.png'></a></td>";
				echo "</tr>";
			} while (($user_data = $result->fetch_assoc()));
		}
		?>
		</table>
		<?php
		if ($searchflag == 1) {
			echo "<div class='noresult'><h1>No Search Results</h1></div>";
		}
		?>
		<div class="pagination">
			<?php
			if (empty($searchedText) && $searchflag != 1) {
				echo "<a href='index.php?page=$previouspage'><button>&laquo;</button></a>";
				for ($i = 1; $i <= $lastpage; $i++) {
					if ($i == $currentpage) {
						echo '<a href="index.php?page=' . $currentpage . '"><button class="active">' . $i . '</button></a>';
					} else {
						echo "<a href='index.php?page=$i'><button>" . $i . "</button></a>";
					}
				}
				echo "<a href='index.php?page=$nextpage'><button>&raquo;</button></a>";
			} else {
				echo "<a href='index.php'><button id='backButton'>Back</button></a>";
			}
			?>
		</div>
	</article>
	<footer>
		<h3>Address</h3>
		<p>#31, Oxford Street, London East, Main City, London, United Kingdom</p>
		<p>Copyright &#169; 2023</p>
	</footer>
</body>

</html>