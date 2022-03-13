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

		<!-- One -->
			<section id="one" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">

						<div> <!-- First box in grid -->
							<div class="box">
								<div class="content">
									<header class="align-center">
										<p>View part information</p>
										<h2>Parts</h2>
									</header>
									<p>
										Explore part information, part structures and history.
										<?php
											$query = "SELECT DISTINCT Number FROM XML_demo.Parts";
											$query = "SELECT DISTINCT Number FROM XML_demo.Parts WHERE Number LIKE '32895%'";
											$result = $conn->query($query);
											echo "<br>Option list contains " . $result->num_rows . " autocomplete options.";
										?>
									</p>

									<!--Make sure the form has the autocomplete function switched off:-->
									<form autocomplete="off" action="part_details.php" method="get" enctype="multipart/form-data">
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
												echo '"option 1"';

//								        while($row = $result->fetch_assoc()){
//													$numPart++;
//								          $partNumber = $row["Number"];
//													if ($numPart!=1){echo ",";}
//								         	echo '"' . $partNumber . '"';
//								        } // end loop all results

												// write array variable closing
												echo ', "option 4"';
												echo "];";
						      		} // end if num_rows > 0
											// end adding parts to textfield autocomplete
										?>
						      	autocomplete(document.getElementById("partNumber"), parts, 100);
						      </script>

								</div>
							</div>
						</div> <!-- End of first box -->


					</div>
				</div>
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
