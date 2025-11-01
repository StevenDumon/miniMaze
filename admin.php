<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
        
        <?php include("scripts/menu.php"); ?>
		
        <?php
			include("scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
		?>

	</head>

    <body class="subpage">

		<!-- Header -->
		<header id="header">
			<div class="logo"><!--<a href="index.php">Hielo <span>by TEMPLATED</span></a>-->miniMaze</div>
			<a href="#menu">Menu</a>
		</header>

        <!--
        <?php writeMenu(); ?>
        -->

		<!-- One -->
		<section id="one" class="wrapper style2">
			<div class="inner">
				<div class="grid-style">

					<div> <!-- First box in grid -->
						<div class="box">
							<!-- <div class="image fit">
								<img src="images/pic02.jpg" alt="" />
							</div> -->
							<div class="content">
								<header class="align-center">
								<p>PHP test</p>
									<!--<h2>Parts</h2>-->
								</header>
								<p>
									<?php
										// PHP test
										echo "<strong>PHP is working!</strong><br>";
										echo "Current PHP version: " . phpversion() . "<br>";

										// Database connection test
										if ($conn->connect_error) {
											die("Connection failed: " . $conn->connect_error);
										}
										echo "<strong>Database connection successful!</strong><br>";
										echo "Connected to database: " . $dbname . "<br>";

										$conn->close();
									?>
								</p>


							</div>
						</div>
					</div> <!-- End of first box -->

                    <div> <!-- Fourth box in grid : database setup -->
						<div class="box">
							<div class="content">
								<header class="align-center">
									<p>Database setup and check</p>
									<h2>Database</h2>
								</header>
								<p>Database Administration.</p>
								<p><a href="scripts/database_setup.php">Table</a> setup script</p>
								<p><a href="../phpMyAdmin-5.1.0-all-languages/index.php">phpMyAdmin</a></p>
							</div>
						</div>
					</div> <!-- End of fourth box -->
				</div>
			</div>
		</section>

		<!-- Footer -->
        <!--
        <footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
					</ul>
				</div>
				<div class="copyright">
					&copy; Untitled. All rights reserved.
				</div>
			</footer>
        -->

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
