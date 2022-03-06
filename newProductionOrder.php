<!DOCTYPE HTML>
<html>
	<head>
		<title>Start new production order</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<?php
			include("scripts/menu.php");
      include("scripts/database_connection.php");
      //include("scripts/partStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
      $startDate=$_GET["startDate"];
      //$partVersion=$_GET["partVersion"];
    ?>

		<script language="Javascript">
			function updateEndDate() {
				var startDateInput = document.getElementById("startDate");
				var startDateValue = startDateInput.value;
				var endDateInput = document.getElementById("endDate");
				// Create new Date instance
				var date = new Date();
				// Add a day
				date.setDate(date.getDate() + 1);
				//endDate.value=startDateValue;
				document.getElementById("endDate").valueAsDate = date;

			} // einde function updateLijst
		</script>

	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><!--<a href="index.html">-->Production planning <!--<span>by TEMPLATED</span></a> --></div>
				<a href="#menu">Menu</a>
			</header>

			<?php writeMenu(); ?>

		<!-- One -->
			<!--<section id="One" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>Eleifend vitae urna</p>
						<h2>Generic Page Template</h2>
					</header>
				</div>
			</section>->

			<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="inner">
					<div class="box">
						<div class="content">
							<!--<header class="align-center">
								<p>maecenas sapien feugiat ex purus</p>
								<h2>Lorem ipsum dolor</h2>
							</header>-->

							<form method="post" action="#">
								<div class="row uniform">

									<?php
									  // Count the number of machines
										$query = "SELECT MachineID FROM XML_demo.Machines";
										$result = $conn->query($query);
										$numMachines = $result->num_rows;

										//Distribute machines in three columns
										$query = "SELECT MachineID, Description FROM XML_demo.Machines";
										$result = $conn->query($query);
										if ($result->num_rows > 0){
									    while($machine = $result->fetch_assoc()){
												$machineID = $machine["MachineID"];
									      $machineName = $machine["Description"];

												echo("<div class='4u 12u$(small)'>");
												echo("	<input type='checkbox' id='machine".$machineID."' name='machine".$machineID."' checked>");
												echo("	<label for='machine".$machineID."'>".$machineName."</label>");;
												echo("</div>");
											}
										}
									?>

								</div>
							</form>
						</div>  <!-- End of class content -->
					</div>  <!-- End of class box -->

					<div class="box">
						<div class="content">
							<!--<header class="align-center">
								<p>maecenas sapien feugiat ex purus</p>
								<h2>Lorem ipsum dolor</h2>
							</header>-->


							<?php
								$query = "SELECT ActionID FROM XML_demo.Actions";
								$result = $conn->query($query);
								$numActions = $result->num_rows;

								echo("<p>");
								echo($numActions." actions in total."."<br>");
								if($startDate==null){
									echo("Geen start datum opgegeven.");
								}
								echo("</p>");
							?>
						</div>
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
