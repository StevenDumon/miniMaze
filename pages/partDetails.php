<html>
	<head>
		<?php
			include("../scripts/database_connection.php");
			include("../scripts/partStructure.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
			$partNumber=$_GET["partNumber"];
			$partVersion=$_GET["partVersion"];

			# Als geen version is opgegeven, zoek dan de meest recente
			if ($partVersion==""){
				// echo "No part version provided.";
				$query = "SELECT Version FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY Version";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$partVersion = $row["Version"];
				}
			}

		?>

		<title>
      Part details <?php echo $partNumber;?>
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
											<p>Part details</p>
											<h2><?php echo $partNumber;?></h2>
										</header>

										<?php
										$query = "SELECT * FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY Version";
							      $result = $conn->query($query);
							      if ($result->num_rows > 0) {
							        $row = $result->fetch_assoc();
							        $partID = $row["PartID"];
							        $partName = $row["Name"];
							        $operation_1 = $row["Operation_1"];
							        $operation_2 = $row["Operation_2"];
							        $operation_3 = $row["Operation_3"];
							        $operation_4 = $row["Operation_4"];
							        $operation_5 = $row["Operation_5"];
							      }

										echo "<p>" . $partName . " [" . $partVersion . "]</p>";
										echo "<p>Operations : ";
										if ($operation_1 != "") {echo $operation_1;}
										if ($operation_2 != "") {echo " -> " . $operation_2;}
										if ($operation_3 != "") {echo " -> " . $operation_3;}
										if ($operation_4 != "") {echo " -> " . $operation_4;}
										if ($operation_5 != "") {echo " -> " . $operation_5;}
										echo "</p>";
										?>

								</div>
							</div>
						</div>

						<div> <!-- Second box in grid -->
							<div class="box">
								<div class="content">

										<header class="align-center">
											<p>Where used</p>
										</header>

										<?php
										// Look for part ID to look for link where this id is used as child ID
							      $childQuery = "SELECT PartID FROM XML_demo.Parts WHERE Number='$partNumber' AND Version='$partVersion'";
							      $childResult = $conn->query($childQuery);
							      if ($childResult->num_rows > 0){
							        $childRow = $childResult->fetch_assoc();
							        $childID= $childRow["PartID"];
							      }

							      // INNER JOIN Query :
							      // SELECT p.Number, p.Version FROM XML_demo.PartUsage u
							      // INNER JOIN XML_demo.Parts p
							      // ON u.parentID = p.partID
							      // WHERE u.ChildID='10806';
							      $parentQuery = "SELECT p.Number, p.Name, p.Version FROM XML_demo.PartUsage u "
							      . "INNER JOIN XML_demo.Parts p "
							      . "ON u.parentID = p.partID "
							      . "WHERE u.ChildID='$childID'";
							      // echo $parentQuery . "<br>";

							      $parentResult = $conn->query($parentQuery);
							      if ($parentResult->num_rows > 0){
							        // Write table header
							        echo "<table><tr><th>Number</th><th>Name</th></tr>";
							        while($parentRow = $parentResult->fetch_assoc()){
							          $parentNumber = $parentRow["Number"];
							          $parentVersion = $parentRow["Version"];
							          $parentName = $parentRow["Name"];
							          echo "<tr><td><a href='part_details.php?partNumber=" . $parentNumber . "&version=" . $parentVersion . "'>$parentNumber</a></td><td>$parentName</td></tr>";
							        }
							        // Write table closing tag
							        echo "</table>";
							      }
							      else{
							        echo "No where-used info available.";
							      }
										?>
										 <!-- End of Where Used -->



										<header class="align-center">
											<p>History</p>
											<!--<h2>XML</h2>-->
										</header>

										<!-- History -->
										<?php
							      // Look for all versions of that part
							      $query = "SELECT Number, Version FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY 'Version'";
							      //echo $query . "<br>";
							      $result = $conn->query($query);

							      if ($result->num_rows > 0){

							        // Write table header
							        echo "<table><tr><th>Version</th><th>Date</th></tr>";

							        // Loop all found versions
							        while($row = $result->fetch_assoc()){
							          $availableVersion = $row["Version"];
							          // Date created of this available version
							          $date="..."; //initial value
							          $dateQuery = "SELECT Created FROM XML_demo.Parts WHERE Number='$partNumber' AND Version='$availableVersion'";
							          $dateResult = $conn->query($dateQuery);
							          if ($dateResultresult->num_rows > 0){
							            $dateRow = $dateResult->fetch_assoc();
							            $date= $dateRow["Created"];
							          }
							          // If initial version is not specified, then use latest version
							          if ($partVersion==""){$partVersion=$availableVersion;}
							          echo "<tr>";
							          echo "<td><a href='part_details.php?partNumber=" . $partNumber ."&partVersion=".$availableVersion."'>$availableVersion</a></td>";
							          echo "<td>$date</td>";
							          echo "</tr>";
											} // einde overlopen alle iteraties

							        // Write table end tag
							        echo "</table>";
										} // end if num_rows > 0
										?> <!-- End writing history -->

									</div>
								</div>
							</div> <!-- End of third box : part history -->

						</div>
					</div>
				</section>


		<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="inner">
					<div class="box">
						<div class="content">
							<div> <!-- Fourth box in grid : part structure -->
								<div class="box">
									<div class="content">
										<header class="align-center">
											<p>Structure</p>
										</header>

										<?php
										echo "<table><tr><th>lvl</th><th>Number</th><th>Name</th><th>Qty</th></tr>";
										// echo "<tr><td>test</td></tr>";
							      writePartRow($conn, $partID, $quantity="", $partLevel=0);
							      $children = getChildren($conn, $partID, $partLevel=0, $numChildren=1);
							      foreach($children as $child) {
							        writePartRow($conn, $child);
							      }

							      // Write table closing tag
							      echo "</table>";
										?>


									</div>
								</div>
							</div> <!-- End of fourth box -->

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
