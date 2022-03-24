<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Create New Production Order</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />

		<?php
			include("partStructure.php");
			include("database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);

			// retrieve incoming parameters :

			//Production order root part number
			if( $_POST["productionOrderRootPart"]) {
				$productionOrderRootPart = $_POST["productionOrderRootPart"];
			} else {$productionOrderRootPart="not specified";}

			//Production order laskwaliteit
			if( $_POST["laskwaliteit"]) {
				$laskwaliteit = $_POST["laskwaliteit"];
			} else {$laskwaliteit="not specified";}

			//Production order afwerkingsgraad
			if( $_POST["afwerkingsgraad"]) {
				$afwerkingsgraad = $_POST["afwerkingsgraad"];
			} else {$afwerkingsgraad="not specified";}

			// message
			if( $_POST["message"]) {
				$message = $_POST["message"];
			} else {$message="";}

			// Requested Date
			if( $_POST["requestedDateComplete"]) {
				$requestedDateComplete = date('Y-m-d', strtotime($_POST['requestedDateComplete']));
			} else {$requestedDateComplete="not specified";}

			// priority
			if( $_POST["priority"]) {
				$priority = $_POST['priority'];
			} else {$priority="not specified";}

			?>

	</head>
	<body class="subpage">

		<!-- Header -->
		<header id="header">
			<div class="logo"><!--<a href="index.php">Hielo <span>by TEMPLATED</span></a>-->miniMaze - Create New Production Order</div>
		</header>

		<div class="inner">
			<div class="box">
				<div class="content">
					<div class="row uniform">
						<div class="6u 12u$(xsmall)">

							<ul>
								<li>Production Order Root Part : <?php echo $productionOrderRootPart; ?></li>
								<li>Requested date : <?php echo $requestedDateComplete; ?></li>
								<li>Laskwaliteit : <?php echo $laskwaliteit; ?></li>
								<li>Afwerkingsgraad : <?php echo $afwerkingsgraad; ?></li>
								<li>Prioriteit : <?php echo $priority; ?></li>
							</ul>

							<?php
								// Controleer of er al een roduction order is geregistreerd met het nummer
								// waarvoor nu een production order zou moeten aangemaakt worden !
								$productionOrderExists=false;

								$query = "SELECT PartNumber FROM XML_demo.ProductionOrders WHERE PartNumber LIKE '" . $productionOrderRootPart . "'";
								$result = $conn->query($query);

								if ($result->num_rows > 0){
									echo "Bestaande productie order voor hetzelfde part number : ";
									// echo "Query : " . $query . "<br>";
									// echo "Results : " . $result->num_rows . "<br>";
									echo "<div class='button'>". $productionOrderRootPart . "</div><br>";
									// echo "Er is reeds een producie order geregistreerd voor " . $productionOrderRootPart . "<br>";
									$productionOrderExists=true;
								} // end if num_rows > 0
							?>

							<?php
								if ($productionOrderExists==false){
									// Add production order to table with production orders
									// Default value voor CreatedDate is ingesteld als CURRENT_TIMESTAMP
									// Actual start date blijft nog open bij creatie production order.

									echo "Create production order." . "<br>";
									$query = "INSERT INTO XML_demo.ProductionOrders ("
										."PartNumber, RequestedCompleteDate, Afwerkingsgraad, Laskwaliteit, Priority, Message"
										.") VALUES ("
											."'$productionOrderRootPart', '$requestedDateComplete', '$laskwaliteit', '$afwerkingsgraad', '$priority', '$message')";

									$result="test mode";
									// $result = $conn->query($query);
									echo "Production order created : " . $result . "<br>";

									echo "Collect individual parts." . "<br>";
									// search for latest version of the production order parts
									$productionOrderRootPartID="";
									$query = "SELECT PartID, Version FROM XML_demo.Parts WHERE Number='" . $productionOrderRootPart . "' ORDER BY Version";
									//echo "Query for root part ID : " . $query . "<br>";
									$result = $conn->query($query);

									while($row = $result->fetch_assoc()){
 										$productionOrderRootPartID=$row["PartID"];
									} // end if num_rows > 0
									echo "Production order root part ID " . $productionOrderRootPartID . "<br>";

									$subParts=getSubparts($conn, $productionOrderRootPartID);


								} // end if production order nog niet bestaat
							?>
						</div>
						<div class="6u$ 12u$(xsmall)">
							<!--show 'back' button only if new production order was created -->
							<?php
								if ($productionOrderExists==false){
									echo "<a href='javascript:history.back()' class='button'>Back</a>";
								}
							 ?>
						</div>
					</div> <!-- end of row uniform -->
				</div> <!-- end class "content"-->
			</div>
		</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>
