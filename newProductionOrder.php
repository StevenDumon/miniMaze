<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - New Production Order</title>
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
				<div class="logo"><!--<a href="index.php">Hielo <span>by TEMPLATED</span></a>-->miniMaze - New Production Order</div>
				<a href="#menu">Menu</a>
			</header>

    <?php writeMenu(); ?>


		<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="inner">
					<div class="box">
						<div class="content">
							<!--<header class="align-center">
								<p>maecenas sapien feugiat ex purus</p>
								<h2>Lorem ipsum dolor</h2>
							</header>
						-->

							<!--
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at dignissim augue, in iaculis neque. Etiam bibendum felis ac vulputate pellentesque. Cras non blandit quam. Nunc porta, est non posuere sagittis, neque nunc pellentesque diam, a iaculis lacus urna vitae purus. In non dui vel est tempor faucibus. Aliquam erat volutpat. Quisque vel est vitae nibh laoreet auctor. In nec libero dui. Nulla ullamcorper, dolor nec accumsan viverra, libero eros rutrum metus, vel lacinia magna odio non nunc. Praesent semper felis eu rhoncus aliquam. Donec at quam ac libero vestibulum pretium. Nunc faucibus vel arcu in malesuada. Aenean at velit odio. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas commodo erat eget molestie sollicitudin. Donec imperdiet, ex sed blandit dictum, ipsum metus ultrices arcu, vitae euismod nisl sapien vitae tortor.</p>
						-->



							<div class="row 200%">
								<div class="6u 12u$(medium)">

									<!-- Text stuff -->
										<h3>Part</h3>
										<p>New production order uses one part as root, the complete part structure is included in the production order</p>

										<form autocomplete="off" method="post" action="scripts/createProductionOrder.php" enctype="multipart/form-data">
					            <p><input type="text" id="productionOrderRootPart" name="productionOrderRootPart" placeholder="Part number"></p>

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

									        	while($row = $result->fetch_assoc()){
															$numPart++;
									          	$partNumber = $row["Number"];
															if ($numPart!=1){echo ",";}
									         		echo '"' . $partNumber . '"';
									        	} // end loop all results

														// write array variable closing
														echo "];";
							      			} // end if num_rows > 0
													// end adding parts to textfield autocomplete
												?>
							      		autocomplete(document.getElementById("productionOrderRootPart"), parts, 100);
							      	</script>

											<!--<div class="12u$">
												<textarea name="description" id="description" placeholder="Description" rows="1"></textarea>
											</div>-->

											<hr \>

											<h3>Planning</h3>
					            <p></p>
											<!-- Break -->
											<div class="row uniform">
												<div class="6u 12u$(xsmall)">
													<p>Requested date</p>
												</div>
												<div class="6u$ 12u$(xsmall)">
													<input type="date" id="requestedDateComplete" name="requestedDateComplete" placeholder="Date complete">
												</div>
											</div>
											<div class="row uniform">
												<div class="4u 12u$(small)">
													<input type="radio" id="priority-low" name="priority">
													<label for="priority-low">Low Priority</label>
												</div>
												<div class="4u 12u$(small)">
													<input type="radio" id="priority-normal" name="priority" checked>
													<label for="priority-normal">Normal Priority</label>
												</div>
												<div class="4u$ 12u$(small)">
													<input type="radio" id="priority-high" name="priority">
													<label for="priority-high">High Priority</label>
												</div>
											</div>

										</div>
										<div class="6u$ 12u$(medium)">

										<h3>Info</h3>

										<div class="row uniform">
											<div class="6u 12u$(xsmall)">
												<select name="laskwaliteit" id="laskwaliteit">
													<option value="">- Laskwaliteit -</option>
													<option value="1">Manufacturing</option>
													<option value="1">Shipping</option>
													<option value="1">Administration</option>
													<option value="1">Human Resources</option>
												</select>
											</div>
											<div class="6u$ 12u$(xsmall)">
												<div class="select-wrapper">
													<select name="afwerkingsgraad" id="afwerkingsgraad">
														<option value="">- Afwerkingsgraad -</option>
														<option value="1">Manufacturing</option>
														<option value="1">Shipping</option>
														<option value="1">Administration</option>
														<option value="1">Human Resources</option>
													</select>
												</div>
											</div>

											<!-- Break -->
											<div class="12u$">
												<textarea name="message" id="message" placeholder="Enter your message" rows="6"></textarea>
											</div>

											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Create Production Order" /></li>
													<li><input type="reset" value="Reset" class="alt" /></li>
												</ul>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div> <!-- end class "content"-->
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
