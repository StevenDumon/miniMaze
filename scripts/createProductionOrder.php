<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Create New Production Order</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />

		<?php
			include("scripts/database_connection.php");
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
			} else {$message="not specified";}

			// Requested Date
			if( $_POST["requestedDateComplete"]) {
				// $requestedDateComplete = $_POST["requestedDateComplete"];
				$requestedDateComplete = date('Y-m-d', strtotime($_POST['requestedDateComplete']));
			} else {$requestedDateComplete="not specified";}

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
					<p>Production Order Root Part : <?php echo $productionOrderRootPart; ?></p>
					<p>Date : <?php echo $requestedDateComplete; ?></p>
					<p>Laskwaliteit : <?php echo $laskwaliteit; ?></p>
					<p>Afwerkingsgraad : <?php echo $afwerkingsgraad; ?></p>
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
