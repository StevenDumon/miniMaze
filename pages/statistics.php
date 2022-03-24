<html>
	<head>
		<?php
			include("../scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
		?>

		<title>
      miniMaze statistics
    </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    <?php include("../scripts/menu.php"); ?>
	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><?php echo $partNumber;?></div>
				<a href="#menu">Menu</a>
			</header>

			<?php writeMenu(); ?>

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
											<p>Statistics</p>
										</header>

                    <h2>Parts</h2>
                    <p>
                    <?php

                    // Total number of parts
                    $query = "SELECT PartID FROM XML_demo.Parts";
                    $result = $conn->query($query);
                    echo "Number of parts : " . $result->num_rows . "<br>";

                    // Number of production order assemblies
                    $query = "SELECT PartID FROM XML_demo.Parts WHERE Number LIKE '%P00%'";
                    $result = $conn->query($query);
                    echo "Number of production order assemblies : " . $result->num_rows . "<br>";
                    ?>

                    <h2>Production orders</h2>
                    <?php

                    // Number of production order launched
                    $query = "SELECT ProductionOrderID FROM XML_demo.ProductionOrders";
                    $result = $conn->query($query);
                    echo "Production orders launched : " . $result->num_rows . "<br>";

                    // Number of parts to be built for production orders
                    $query = "SELECT ProductionPartID FROM XML_demo.ProductionParts";
                    $result = $conn->query($query);                    echo "<p>";
                    echo "Parts to be built : " . $result->num_rows . "<br>";
                    ?>

                    <h2>XML imports</h2>
                    <?php

                    $query = "SELECT ImportID FROM XML_demo.ImportLog";
                    $result = $conn->query($query);
                    echo "Number of imports : " . $result->num_rows . "<br>";
                    ?>

								</div>
							</div>
						</div>
					</div>
				</section>

		<!-- Footer -->
		<!--	<footer id="footer">
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
			</footer>-->

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
  </body>
</html>
