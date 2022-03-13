<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Create New Production Order</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    <!--<?php include("menu.php"); ?>-->
		<?php
			include("scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);

			// retrieve incoming parameters :

			//Production order root part number
			if( $_POST["productionOrderRootPart"]) {
				$productionOrderRootPart = $_POST["productionOrderRootPart"];
			} else {$productionOrderRootPart="not specified";}

			// message
			$message = $_POST["message"]);
			if( $_POST["message"]) {
				$message = $_POST["message"]);
				$message="found ?";
			} else {
				$message="not specified";
			}


   		if( $_POST["name"] || $_POST["age"] ) {
      	if (preg_match("/[^A-Za-z'-]/",$_POST['name'] )) {
         	die ("invalid name and name should be alpha");
      	}
      	echo "Welcome ". $_POST['name']. "<br />";
      	echo "You are ". $_POST['age']. " years old.";

      	exit();
   		}
			?>

	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><!--<a href="index.php">Hielo <span>by TEMPLATED</span></a>-->miniMaze - Create New Production Order</div>
				<!--<a href="#menu">Menu</a>-->
			</header>

    <?php //writeMenu(); ?>

		<div class="inner">
			<div class="box">
				<div class="content">
					<p>Production Order Root Part : <?php echo $productionOrderRootPart; ?>
					<p>Message : <?php echo $message; ?>
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
