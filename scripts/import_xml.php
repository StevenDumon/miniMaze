<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
    <?php
      include("menu.php");
      include("database_connection.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
      // ["name"] refers to the filename on the client-side.
      $original_filename = $_FILES["xml_file"]["name"];
      // To get the filename (including the full path)
      // on the server-side, you need to use ["tmp_name"]:
      $xml_file = $_FILES["xml_file"]["tmp_name"];
    ?>

    <title>Import XML <?php echo $original_filename;?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />

	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
        <div class="logo"><!--<a href="index.html">-->XML file imported <!--<span>by TEMPLATED</span></a> --></div>
				<a href="#menu">Menu</a>
			</header>

		<?php writeMenu(); ?>

		<!-- One -->
			<!-- <section id="One" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>Eleifend vitae urna</p>
						<h2>Generic Page Template</h2>
					</header>
				</div>
			</section> -->

		<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="inner">
					<div class="box">
						<div class="content">
							<!--<header class="align-center">
								<p>maecenas sapien feugiat ex purus</p>
								<h2>Lorem ipsum dolor</h2>
							</header>-->

              <h1>XML file import</h1>

              <?php

                echo "<table><tr><th width='150px'>File</th><th>filename</th></tr>";
                echo "<tr><td>Selected file</td><td>" . $original_filename . "</td></tr>";
                echo "<tr><td>Uploaded file</td><td>" . $xml_file . "</td></tr></table>";

                $fileContent = file_get_contents($_FILES['xml_file']['tmp_name']);
                $xml = new SimpleXMLElement($fileContent);

                echo "<h2>Production order</h2>";
                // echo "<div class='container'><div class='row'><div class='twelve columns'>";
                $projectNumber = $xml->projectnumber[0];
                $productionOrder = (string) $xml->productionordernumber;
                $date = $xml->date;
                echo "Project " . $projectNumber . ", productie order " . $productionOrder . "<br>";
                echo "Date " . $date . "<br>";

                // echo "<h2>Top part</h2>";
                // echo $xml->parts->part[0]->number[0]; // get single value

                //Loop trough all parts
                echo "<h2>Part list</h2>";
                echo "<table><tr><th>pos</th><th>Number</th><th width='25%'>name</th><th>Version</th><th>Dimensions</th><th>Status</th></tr>";
                $partCount=1;
                foreach($xml->parts->part as $part)
                {
                  echo "<tr>";
                  echo "<td>" . $partCount . "</td>";
                  echo "<td>" . "<a href=../part_details.php?partNumber=" .$part->number . "&version=" .$part->version . ">" .$part->number . "</a></td>";
                  echo "<td>" . $part->name . "</td>";
                  echo "<td>" . $part->version . "</td>";
                  echo "<td>" . $part->dimension . "</td>";

                  // check if part is already in database (combination of number and version)
                  $query = "SELECT Number, Version FROM XML_demo.Parts WHERE Number='$part->number' AND Version='$part->version'";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                    // Existing part found, don't add again
                    echo "<td>Existing</td>";
                  }
                  else {
                    // add part to database
                    // Get operations from XML
                    // <operations>
                    //   <operation>ZA</operation>
                    //   <operation>VP</operation>
                    // </operations>
                    $operation_1 = $part->operations->operation[0];
                    $operation_2 = $part->operations->operation[1];
                    $operation_3 = $part->operations->operation[2];
                    $operation_4 = $part->operations->operation[3];
                    $operation_5 = $part->operations->operation[4];

                    $query = "INSERT INTO XML_demo.Parts ("
                      ."Number, Name, Version, Created, Operation_1, Operation_2, Operation_3, Operation_4, Operation_5"
                      .") VALUES ("
                      ."'$part->number', '$part->name', '$part->version', '$date', '$operation_1', '$operation_2', '$operation_3', '$operation_4', '$operation_5')";
                    $result = $conn->query($query);
                    echo "<td>New</td>";
                  }
                  echo "<tr/>";
                  $partCount++;
                }
                echo "</table>";

                //Loop trough all part usage links
                echo "<h2>Usage links</h2>";
                $usageLinkCount=1;
                //echo "<div class='container'><div class='row'><div class='twelve columns'>";
                echo "<table><tr><th>pos</th><th>Parent</th><th>Version</th><th>ID</th><th>Child</th><th>Version</th><th>ID</th></tr>";
                foreach($xml->usageLinks->usageLink as $usageLink)
                {

                  $parentNumber = $usageLink->parent->number;
                  $parentVersion = $usageLink->parent->version;
                  $childNumber = $usageLink->child->number;
                  $childVersion = $usageLink->child->version;

                  // first look for parent ID
                  $query = "SELECT PartID FROM XML_demo.Parts WHERE Number='$parentNumber' AND Version='$parentVersion'";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                    $parent = $result->fetch_assoc();
                    $parentID = $parent["PartID"];
                  }
                  // also look for child ID
                  $query = "SELECT PartID FROM XML_demo.Parts WHERE Number='$childNumber' AND Version='$childVersion'";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                    $child = $result->fetch_assoc();
                    $childID = $child["PartID"];
                  }

                  echo "<tr><td>" . $usageLinkCount . "</td>";
                  echo "<td>" . $usageLink->parent->number . "</td>";
                  echo "<td>" . $usageLink->parent->version . "</td>";
                  echo "<td>" . $parentID . "</td>";
                  echo "<td>" . $usageLink->child->number . "</td>";
                  echo "<td>" . $usageLink->child->version . ")" . "</td>";
                  echo "<td>" . $childID . "</td></tr>";

                  // look for existing usageLink
                  $query = "SELECT PartUsageID FROM XML_demo.PartUsage WHERE parentID='$parentID' AND childID='$childID'";
                  $result = $conn->query($query);
                  if ($result->num_rows > 0) {
                    // Existing part usage found, don't add again
                    //echo "<td>Existing part</td>";
                  }
                  else {
                    //add part usage link to database
                    $query = "INSERT INTO XML_demo.PartUsage (parentID, childID, Quantity, Certificate) VALUES ('$parentID', '$childID', '$usageLink->quantity', '$usageLink->certificate')";
                    //echo "Add link to parent " . $parentID . " and child " . $childID . "<br>";
                    $result = $conn->query($query);
                    //echo "<td>new</td>";
                  }
                  $usageLinkCount++;
                }
                echo "</table>";
                //echo "</div><!--end of class 'twelve columns'</div>--></div><!--end of class 'Row'--></div>";
                // echo ($usageLinkCount-1) . " links found" . "<br>";

                echo "<h2>Add log</h2>";
                echo "<div class='container'><div class='row'><div class='twelve columns'>";
                $query = "INSERT INTO XML_demo.ImportLog (filename, CreateDate) VALUES ('$original_filename', '$date')";
                echo $query . "<br>";
                $result = $conn->query($query);
                echo "</div><!--end of class 'twelve columns'</div>--></div><!--end of class 'Row'--></div>";

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
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>
