<!DOCTYPE HTML>
<html>
	<head>
		<title>Database test</title>
	    <?php include("database_connection.php"); ?>
	</head>

	<body>
		<h1>Database Test Page</h1>
		<?php
			echo "<p>Connecting to database ";
			echo "<b>" . $dbname . "</b>";
			echo " on server ";
			echo "<b>" . $servername . "</b>";
			echo "</p>";

			$conn = new mysqli($servername, $username, $password, $dbname);
			echo "<p>Connected !</p>";
			?>
		<p><a href="../../index.php">Return to home page</a></p>
	</body>
</html>
