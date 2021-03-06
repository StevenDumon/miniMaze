<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
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
										<p>Investigate things</p>
										<h2>Parts</h2>
									</header>
									<p>
										Explore part information, part structures and history.
									</p>

									<!--Make sure the form has the autocomplete function switched off:-->
									<form autocomplete="off" action="pages/part_details.php" method="get" enctype="multipart/form-data">
				            <p><input type="text" id="partNumber" name="partNumber" placeholder="Part number"></p>
										<footer class="align-center">
											<input type="submit" value="Search" class="button alt">
										</footer>
				          </form>


									<!-- Autocomplete -->
						      <script src="scripts/autoComplete.js"></script>
									<script>
										<?php

											$query = "SELECT DISTINCT Number FROM XML_demo.Parts ORDER BY Number";
							      	$result = $conn->query($query);
											$numPart=0; // use counter to avoid printing comma before first result


											if ($result->num_rows > 0){
												// write array var declaration
												echo 'var parts = [';
												//echo '"option 1"';

								        while($row = $result->fetch_assoc()){
													$numPart++;
								          $partNumber = $row["Number"];
													if ($numPart!=1){echo ",";}
								         	echo '"' . $partNumber . '"';
								        } // end loop all results

												// write array variable closing
												// echo ', "option 4"';
												echo "];";
						      		} // end if num_rows > 0
											// end adding parts to textfield autocomplete
										?>
						      	autocomplete(document.getElementById("partNumber"), parts, 100);
						      </script>

								</div>
							</div>
						</div> <!-- End of first box -->


						<div>
							<div class="box">
								<!-- <div class="image fit">
									<img src="images/pic03.jpg" alt="" />
								</div> -->
								<div class="content">
									<header class="align-center">
										<p>Start things</p>
										<h2>Production orders</h2>
									</header>
									<p>Use the planning tool to follow production orders, resources and machine usage.</p>
									<div class="row uniform">
										<div class="8u 12u$(xsmall)">
											<input type="text" id="productionOrderNumber" name="productionOrderNumber" placeholder="Production order number">
										</div>
										<div class="3u 12u$(xsmall)">
											<a href="pages/viewProductionOrder.php" class="button alt">Search</a>
										</div>
									</div> <!-- end of row uniform -->
									<div class="row uniform">
										<div class="4u 12u$(xsmall)">
										</div>
										<div class="4u 12u$(xsmall)">
											<a href="newProductionOrder.php" class="button alt">New</a>
										</div>
										<div class="4u 12u$(xsmall)">
										</div>
									</div> <!-- end of row uniform -->
								</div> <!-- end of Content -->
							</div> <!-- end of Box" -->
						</div>
						<script>
							<?php

								$query = "SELECT DISTINCT ProductionOrderID, PartNumber FROM XML_demo.ProductionOrders ORDER BY PartNumber";
								$result = $conn->query($query);
								$numPart=0; // use counter to avoid printing comma before first result

								if ($result->num_rows > 0){
									// write array var declaration
									echo 'var productionOrderNumbers = [';
									//echo '"option 1"';

									while($row = $result->fetch_assoc()){
										$numPart++;
										$partNumber = $row["PartNumber"];
										if ($numPart!=1){echo ",";}
										echo '"' . $partNumber . '"';
									} // end loop all results

									// write array variable closing
									// echo ', "option 4"';
									echo "];";
								} // end if num_rows > 0
								// end adding parts to textfield autocomplete
							?>
							autocomplete(document.getElementById("productionOrderNumber"), productionOrderNumbers, 100);
						</script>

						<div>
							<div class="box">
								<!-- <div class="image fit">
									<img src="images/pic03.jpg" alt="" />
								</div> -->
								<div class="content">
									<header class="align-center">
										<p>Make things</p>
										<h2>Machine dashboard</h2>
									</header>
									<p>Present parts to be built for particular workstations or machines.</p>
									<footer class="align-center">
										<a href="machineDashboard.php" class="button alt">My machine</a>
									</footer>
								</div>
							</div> <!-- end of class Box" -->
						</div>

						<div>
							<div class="box">
								<!-- <div class="image fit">
									<img src="images/pic03.jpg" alt="" />
								</div> -->
								<div class="content">
									<header class="align-center">
										<p>Schedule work</p>
										<h2>Planning</h2>
									</header>
									<p>Use the planning tool to follow production orders, resources and machine usage.</p>
									<footer class="align-center">
										<a href="planning.php" class="button alt">Planning</a>
									</footer>
								</div>
							</div> <!-- end of class Box" -->
						</div>

            <div> <!-- Third box, starts a new row in grid depending on window size -->
							<div class="box">
								<!-- <div class="image fit">
									<img src="images/pic02.jpg" alt="" />
								</div> -->
								<div class="content">
									<header class="align-center">
										<p>Import things</p>
										<h2>Import XML</h2>
									</header>
									<p>Import XML structure files to make PLM parts available for production</p>
									<footer class="align-center">
										<a href="selectXML.php" class="button alt">Import XML</a>
									</footer>
								</div>
							</div>
						</div> <!-- End of third box : import XML -->

            <div> <!-- Fourth box in grid : database setup -->
							<div class="box">
								<!-- <div class="image fit">
									<img src="images/pic02.jpg" alt="" />
								</div> -->
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

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
