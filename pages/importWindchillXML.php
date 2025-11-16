<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Import Windchill structure</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    	<?php include("../scripts/menu.php"); ?>
    	<?php include("../classes/WTPart.php"); ?>
		<?php
			include("../scripts/database_connection.php");
			// $conn = new mysqli($servername, $username, $password, $dbname);
		?>

		<?php
			$columnHeaders = ["Structure Level", "Number", "CAD Number", "Version", "Quantity", "Name", "Omschrijving stuklijst NL", "BOM afmetingen", "GDF_NORM", "Materiaal", "Attest", "Gewicht", "Bewerking 1 in BOM", "Bewerking 2 in BOM", "Bewerking 3 in BOM", "Bewerking 4 in BOM", "Bewerking 5 in BOM", "Grondstofnummer", "Snede", "State"];
			$columnIndexes = [];
			$columnIndexes["Structure Level"] = -1;
			$columnIndexes["Number"] = -1;
			$columnIndexes["CAD Number"] = -1;
			$columnIndexes["Version"] = -1;
			$columnIndexes["Quantity"] = -1;
			$columnIndexes["Name"] = -1;
			$columnIndexes["Omschrijving stuklijst NL"] = -1;
			$columnIndexes["BOM afmetingen"] = -1;
			$columnIndexes["GDF_NORM"] = -1;
			$columnIndexes["Materiaal"] = -1;
			$columnIndexes["Attest"] = -1;
			$columnIndexes["Gewicht"] = -1;
			$columnIndexes["Bewerking 1 in BOM"] = -1;
			$columnIndexes["Bewerking 2 in BOM"] = -1;
			$columnIndexes["Bewerking 3 in BOM"] = -1;
			$columnIndexes["Bewerking 4 in BOM"] = -1;
			$columnIndexes["Bewerking 5 in BOM"] = -1;
			$columnIndexes["Grondstofnummer"] = -1;
			$columnIndexes["Snede"] = -1;
			$columnIndexes["State"] = -1;
		?>

	</head>
	<body class="subpage">

		<!-- Header -->
		<header id="header">
			<div class="logo">miniMaze > Import Windchill structure</div>
			<a href="#menu">Menu</a>
		</header>

    	<?php writeMenu(); ?>

		<!-- One -->
		<section id="one" class="wrapper style2">
			<div class="inner">
				<div class="box">
					<div class="content">
						<header class="align-center">
							<p>Import Windchill parts and structures</p>
							<h2>Processing...</h2>
						</header>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                            //Controleer of er een bestand is geüpload zonder fouten
                            if (isset($_FILES['XMLfile']) && $_FILES['XMLfile']['error'] === UPLOAD_ERR_OK) {
                                $tmpName = $_FILES['XMLfile']['tmp_name']; // tijdelijk pad
                                $fileName = basename($_FILES['XMLfile']['name']);
                                $fileType = $_FILES['XMLfile']['type'];
                                $fileSize = $_FILES['XMLfile']['size'];

                                // file size limiet 10MB
                                if ($fileSize > 10 * 1024 * 1024) {
                                    echo "Bestand is te groot. Maximaal 10MB toegestaan.";
                                    exit;
                                }
                                //Lees de inhoud van de file
                                $fileContent = file_get_contents($tmpName);

                                // Verwerk file content en voeg data toe in database

                                echo "<p>";
								echo "File <strong>" . htmlspecialchars($fileName) . "</strong> ingelezen.<br>";
								echo "String length is " . strlen($fileContent) . " chars.";
								echo "</p>";
								// echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";

								// XML file regel per regel overlopen
								$lineNumber = 0;
								// colom index teller op nul zetten
								$columnIndexCounter = 0;
								//lijst met parts
								$partsList = array();
								// part 'under construcion', collecting attributes
								$newPart = null;

								foreach (explode("\n", $fileContent) as $line) {
									// echo htmlspecialchars($line) . "<br>";
									// elke lijn overlopen tot einde van de lijn
									$lineNumber++;
									$positionInLine=0;
									$lineLength = strlen($line);
									while ($positionInLine < $lineLength) {
										// $char = $line[$positionInLine];
										// elk karakter overlopen tot einde van de lijn
										$positionInLine++;

										// reageren op deze tags :
										//   <ColumnName>
										//   <Object>
										//   </Object>
										//   <Attribute>

										// <ColumnName>...</ColumnName>
										//   - kolom tellen voor attributen en
										//   - in functie van de kolomkop de index van de kolommen onthouden
										if (substr($line, $positionInLine - strlen("<ColumnName>") - 1, strlen("<ColumnName>")) === "<ColumnName>") {
											// kolomnaam beginnen lezen
											$endTagPos = strpos($line, "</ColumnName>", $positionInLine)+1;
											if ($endTagPos !== false) {
												$columnName = trim(substr($line, $positionInLine-1, $endTagPos - $positionInLine));
												// echo "Kolomnaam gevonden: " . htmlspecialchars($columnName) . "<br>";
												// kolom index zoeken
												$columnIndex = array_search($columnName, $columnHeaders);
												if ($columnIndex !== false) {
 													// $columnIndexes[$columnName] = $columnIndex;
													$columnIndexes[$columnName] = $columnIndexCounter;
													$columnIndexCounter++;
												} else {
													echo "Kolomnaam " . htmlspecialchars($columnName) . " niet herkend.<br>";
												}
												$positionInLine = $endTagPos + strlen("</ColumnName>");
											}
										}

									
										// <Object> begint een nieuw artikel
										//       Kolom index teller terug op nul zetten.
										//       Assembly level verhogen met 1
										if (substr($line, $positionInLine - strlen("<Object>") - 1, strlen("<Object>")) === "<Object>") {

											// bij overgang van een assembly naar een part-in-die-assembly wordt de assembly niet
											// afgesloten met </Object>, maar begint er direct een nieuw <Object>
											// dus als er al een part in opbouw is, deze eerst toevoegen aan de parts lijst
											if ($newPart != null) {
												$partsList[] = $newPart->clone();
												echo "Einde van artikel (lijn ". $lineNumber . ", pos " . $positionInLine . ").<br>";
												// write end of attribute summary
												echo "</ol>";
												// clear newPart to null
												$newPart->clearPart();

											}
											// nieuw artikel beginnen
											echo "Nieuw artikel begonnen (lijn ". $lineNumber . ", pos " . $positionInLine . ").<br>";
											$newPartOperations = array("", "", "", "", "");
											$newPart = new WTPart("", "", "", "", "", "", "", "", "", "", $newPartOperations, "", "", "");
											// kolom index teller op nul zetten
											$columnIndexCounter = 0;

											$positionInLine += strlen("<Object>") - 1;
											// write start of attribute summary
											echo "<ol>";

										}

										// </Object> einde van een artikel
										//       Assembly level verlagen met 1
										if (substr($line, $positionInLine - strlen("</Object>"), strlen("</Object>")) === "</Object>") {
											// einde van een artikel, voeg part toe aan parts lijst
											// wanneer partname niet leeg is, typisch voor allerlaatste artikel in de structuur
											if ($newPart != null && $newPart->partname != "") {											
												$partsList[] = $newPart->clone();
												echo "Einde van artikel (lijn ". $lineNumber . ", pos " . $positionInLine . ").<br>";
												// write end of attribute summary
												echo "</ol>";
												// clear newPart to null
												$newPart->clearPart();
											// $positionInLine += strlen("</Object>") -2;
											}
										}

										// <Attribute> vult een eigenschap van het part in, in functie van de index
										//        van dat attribuut binnen het part dat gelezen wordt
										if (substr($line, $positionInLine - strlen("<Attribute>") - 1, strlen("<Attribute>")) === "<Attribute>") {
											// attribuut van het artikel beginnen lezen
											$columnName = $columnHeaders[$columnIndexCounter - 1];
											$endTagPos = strpos($line, "</Attribute>", $positionInLine - strlen("<Attribute>")) +1;
											if ($endTagPos !== false) {
												$attributeValue = trim(substr($line, $positionInLine-1, $endTagPos - $positionInLine));
												echo "<li>Attribuut " . $columnIndexCounter .": <strong>" . $columnName . "</strong> : " . htmlspecialchars($attributeValue) . "<br>";
												// echo "Start at " . $positionInLine. ", endTagPos=" . $endTagPos;
												echo "</li>";
												// attribuut toewijzen aan part in functie van de kolom index
												if ($columnIndexCounter == $columnIndexes["Number"]) {
												    $newPart->partNumber = $attributeValue;
													echo "Attribute for Part number set to " . htmlspecialchars($attributeValue) . "<br>";
												} elseif ($columnIndexCounter == $columnIndexes["CAD Number"]) {
													$newPart->CADNumber = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Version"]) {
													$newPart->version = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Name"]) {
													$newPart->name = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Omschrijving stuklijst NL"]) {
													$newPart->description = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Materiaal"]) {
													$newPart->material = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Gewicht"]) {
													$newPart->weight = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["BOM afmetingen"]) {
													$newPart->dimensions = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Attest"]) {
													$newPart->attest = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["GDF_NORM"]) {
													$newPart->norm = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Bewerking 1 in BOM"]) {
													$newPart->operations[0] = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Bewerking 2 in BOM"]) {
													$newPart->operations[1] = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Bewerking 3 in BOM"]) {
													$newPart->operations[2] = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Bewerking 4 in BOM"]) {
													$newPart->operations[3] = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Bewerking 5 in BOM"]) {
													$newPart->operations[4] = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Grondstofnummer"]) {
													$newPart->RMnumber = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Snede"]) {
													$newPart->remarks = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["State"]) {
													$newPart->state = $attributeValue;
												}

												$positionInLine = $endTagPos + strlen("</Attribute>");
											}
											$columnIndexCounter++;
										}

									} // einde while elke lijn overlopen

								} // einde foreach lijn


								echo "Import voltooid.";

                            } else {
                                echo "Fout bij upload...";
                            }
                        } 
                        else {
                            echo "Ongeldige aanvraag.";
                        }
                        ?>

						<h2>Kolom index overzicht</h2>

						<?php
							echo "<ul>";

							echo "<li>Kolom index voor Structure Level: " . $columnIndexes["Structure Level"] . "</li>";
							echo "<li>Kolom index voor Number: " . $columnIndexes["Number"] . "</li>";
							echo "<li>Kolom index voor CAD Number: " . $columnIndexes["CAD Number"] . "</li>";
							echo "<li>Kolom index voor Version: " . $columnIndexes["Version"] . "</li>";
							echo "<li>Kolom index voor Quantity: " . $columnIndexes["Quantity"] . "</li>";
							echo "<li>Kolom index voor Name: " . $columnIndexes["Name"] . "</li>";
							echo "<li>Kolom index voor Omschrijving stuklijst NL: " . $columnIndexes["Omschrijving stuklijst NL"] . "</li>";
							echo "<li>Kolom index voor BOM afmetingen: " . $columnIndexes["BOM afmetingen"] . "</li>";
							echo "<li>Kolom index voor GDF_NORM: " . $columnIndexes["GDF_NORM"] . "</li>";
							echo "<li>Kolom index voor Materiaal: " . $columnIndexes["Materiaal"] . "</li>";
							echo "<li>Kolom index voor Attest: " . $columnIndexes["Attest"] . "</li>";
							echo "<li>Kolom index voor Gewicht: " . $columnIndexes["Gewicht"] . "</li>";
							echo "<li>Kolom index voor Bewerking 1 in BOM: " . $columnIndexes["Bewerking 1 in BOM"] . "</li>";
							echo "<li>Kolom index voor Bewerking 2 in BOM: " . $columnIndexes["Bewerking 2 in BOM"] . "</li>";
							echo "<li>Kolom index voor Bewerking 3 in BOM: " . $columnIndexes["Bewerking 3 in BOM"] . "</li>";
							echo "<li>Kolom index voor Bewerking 4 in BOM: " . $columnIndexes["Bewerking 4 in BOM"] . "</li>";
							echo "<li>Kolom index voor Bewerking 5 in BOM: " . $columnIndexes["Bewerking 5 in BOM"] . "</li>";
							echo "<li>Kolom index voor Grondstofnummer: " . $columnIndexes["Grondstofnummer"] . "</li>";
							echo "<li>Kolom index voor Snede: " . $columnIndexes["Snede"] . "</li>";
							echo "<li>Kolom index voor State: " . $columnIndexes["State"] . "</li>";
							echo "</ul>";
                        ?>

						<h2>Parts</h2>
						<?php
						foreach ($partsList as $part) {
							echo "<p>" . htmlspecialchars($part->ToString()) . "</p>";
						}
						
                        ?>
                        <!--<p>Importeer Multilevel BOM reports uit Windchill in de Modelstructure for BOM view, geëxporteerd als XML bestand.</p>-->

                    </div> <!-- class="content"-->
                </div> <!-- class="box" -->
            </div> <!-- class="inner" -->
			<div class="inner">
				<div class="box">
					<div class="content">
						<p><a href="selectWindchillXML.php" class="button alt">Terug naar upload pagina</a></p>
                    </div> <!-- class="content"-->
                </div> <!-- class="box" -->
			</div> <!-- class="inner" -->
        </section>

		<!-- Footer -->
         <!--

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
                                    -->

		<!-- Scripts -->
		<script src="../assets/js/jquery.min.js"></script>
		<script src="../assets/js/jquery.scrollex.min.js"></script>
		<script src="../assets/js/skel.min.js"></script>
		<script src="../assets/js/util.js"></script>
		<script src="../assets/js/main.js"></script>
	</body>
</html>
