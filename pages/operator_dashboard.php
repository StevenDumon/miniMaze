<!DOCTYPE HTML>
<html>
	<head>
		<title>Operator Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<?php
			include("../scripts/menu.php");
      include("../scripts/database_connection.php");
      //include("scripts/partStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><!--<a href="index.html">-->Machine Operator Dashboard <!--<span>by TEMPLATED</span></a> --></div>
				<a href="#menu">Menu</a>
			</header>

			<?php writeMenu(); ?>

		<section id="" class="wrapper style2">

			<div class="inner"> <!-- left and right margin -->
				<div class="row 200%">
					<div class="3u 12u$(medium)">
						<div class="box"> <!-- white box background -->
							<div class="content"> <!-- margin between content and white border -->
								<form action="part_details.php" method="get" enctype="multipart/form-data">
									<p>
										<label>Project</label>
										<select projectNumber>
											<option>10001</option>
											<option>10002</option>
										</select>
									</p>
									<p>
										<label>Productie Order</label>
										<select productieOrderNumber>
											<option>10001-P00001</option>
											<option>10001-P00002</option>
											<option>10002-P00001</option>
											<option>10002-P00002</option>
										</select>
									</p>
									<p>
										<label>Productie Order</label>
										<select productieOrderNumber>
											<option>c00123454</option>
											<option>c00123455</option>
											<option>c00123456</option>
											<option>c00123457</option>
											<option>c00123458</option>
											<option>c00123459</option>
										</select>
									</p>
			            <input type="submit" value="Details">
			          </form>
							</div> <!-- End of content -->
						</div> <!-- End of box, white background -->
					</div> <!-- end of left column -->
					<div class="9u$ 12u$(medium)"> <!-- start of right column -->
						<div class="box"> <!-- white box background -->
							<div class="content"><p>Content in BOX in 9u$ 12u$</p></div>
						</div> <!-- End of box, white background -->
					</div> <!-- end of right column -->
				</div> <!-- End of row 200 -->
			</div> <!-- End of inner, left and right margins -->

		</section>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.scrollex.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
	</body>
</html>
