<?php

include_once("config.php");
require("auth_session.php");

if (isset($_POST['Search'])) {
	$searchedText = $_POST['searchedText'];
	$sql = "SELECT * from employees WHERE name LIKE '%$searchedText%';";
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
	$sql = "SELECT * from employees ORDER BY id DESC LIMIT $entriesperpage OFFSET $lastentry";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Employees Details</title>
	<link rel="stylesheet" href="table.css" />
</head>

<body>
	<header>
		<img src="assets/icons8-lock-50 (1).png">
		<h1>Keep Safe</h1>
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
				<a href="create.php"><button>Add</button></a>
				<a href="logout.php"><button id="logoutButton">Log out</button></a>
			</div>
		</div>
		<table>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Newsletter</th>
				<th>Creation Time</th>
				<th>Modification Time</th>
				<th>Edit Details</th>
			</tr>
			<?php
			while ($user_data = $result->fetch_assoc()) {
				if ($user_data['newsletter'] == 1) {
					$newsletter = "Yes";
				} else {
					$newsletter = "No";
				}
				echo "<tr>";
				echo "<td>" . $user_data['name'] . "</td>";
				echo "<td>" . $user_data['email'] . "</td>";
				echo "<td>" . $user_data['gender'] . "</td>";
				echo "<td>" . $user_data['address'] . "</td>";
				echo "<td>" . $user_data['city'] . "</td>";
				echo "<td>" . $user_data['state'] . "</td>";
				echo "<td>" . $newsletter . "</td>";
				echo "<td>" . $user_data['created_at'] . "</td>";
				echo "<td>" . $user_data['modified_at'] . "</td>";
				echo "<td><a href='update.php?id=" . $user_data['id'] . "'><button id='editbutton'>Edit</button></a><a href='delete.php?id=" . $user_data['id'] . "'><button id='deletebutton'>Delete</button></a></td>";
				echo "</tr>";
			}
			?>
		</table>
		<div class="pagination">
			<?php
			echo "<a href='index.php?page=$previouspage'><button>&laquo;</button></a>";
			for ($i = 1; $i <= $lastpage; $i++) {
				if ($i == $currentpage) {
					echo '<a href="index.php?page=' . $currentpage . '"><button class="active">' . $i . '</button></a>';
				} else {
					echo "<a href='index.php?page=$i'><button>" . $i . "</button></a>";
				}
			}
			if (empty($searchedText)) {
				echo "<a href='index.php?page=$nextpage'><button>&raquo;</button></a>";
			}
			?>
		</div>
	</article>
	<footer>
		<h3>Address</h3>
		<p>#31, Oxford Street, London East, Main City, London, United Kingdown</p>
		<p>Copyright &#169; 2023</p>
	</footer>
</body>

</html>