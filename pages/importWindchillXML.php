<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Import Windchill structure</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    	<?php
			include("../scripts/menu.php");
    		include("../classes/WTPart.php");
			include("../scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
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
						</header>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                            //Controleer of er een bestand is geüpload zonder fouten
                            if (isset($_FILES['XMLfile']) && $_FILES['XMLfile']['error'] === UPLOAD_ERR_OK) {
                                $tmpName = $_FILES['XMLfile']['tmp_name']; // tijdelijk pad
                                $fileName = basename($_FILES['XMLfile']['name']);
                                $fileType = $_FILES['XMLfile']['type'];
                                $fileSize = $_FILES['XMLfile']['size'];

								echo "<h2 id='importStatus'>Processing file: " . htmlspecialchars($fileName) . "</h2>" . PHP_EOL;
								// Output buffering, flush output to browser immediately
								ob_flush();
								flush();

                                // file size limiet 10MB
                                if ($fileSize > 10 * 1024 * 1024) {
                                    echo "Bestand is te groot. Maximaal 10MB toegestaan.";
                                    exit;
                                }
                                //Lees de inhoud van de file
                                $fileContent = file_get_contents($tmpName);

                                // Verwerk file content en voeg data toe in database
								// echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";

								// XML file regel per regel overlopen
								$lineNumber = 0;
								// colom index teller op nul zetten
								$columnIndexCounter = 0;
								// lijst met parts
								$partsList = array();
								// lijst met parent-child relaties
								$parentChildRelations = array();
								// part 'under construcion', collecting attributes
								$newPart = null;
								//parameters voor parent-child relatie
								$quantity = 0;
								$certificateType = "";

								foreach (explode("\n", $fileContent) as $line) {
									// elke lijn overlopen tot einde van de lijn
									$lineNumber++;
									$positionInLine=0;
									$lineLength = strlen($line);
									while ($positionInLine < $lineLength) {
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
											if ($newPart != null && $newPart->name != "") {
												$partsList[] = $newPart->clone();
												// parent opzoeken wanneer niet op top-assembly level
												if (count($partsList) > 1) {
													$newParentChildRelation = new ParentChildRelation(null, null, null, null, $quantity, $certificateType);
													$newParentChildRelation = $newParentChildRelation->getParentChildObject($partsList, $quantity, $certificateType);
													$parentChildRelations[] = $newParentChildRelation;
												}
												$newPart->clearPart();

											}
											// nieuw artikel beginnen
											//echo "Nieuw artikel begonnen (lijn ". $lineNumber . ", pos " . $positionInLine . ").<br>";
											$newPartOperations = array("", "", "", "", "");
											$newPart = new WTPart(0, "", "", "", "", "", "", "", "", "", "", $newPartOperations, "", "", "");
											// kolom index teller op nul zetten
											$columnIndexCounter = 0;

											$positionInLine += strlen("<Object>") - 1;

										}

										// </Object> einde van een artikel
										//       Assembly level verlagen met 1
										if (substr($line, $positionInLine - strlen("</Object>"), strlen("</Object>")) === "</Object>") {
											// einde van een artikel, voeg part toe aan parts lijst
											// wanneer partnumber niet leeg is, typisch voor allerlaatste artikel in de structuur
											if ($newPart != null && $newPart->name != "") {
												$partsList[] = $newPart->clone();
												
												$newPart->clearPart();
											}
										}

										// </SearchResults> einde van laatste artikel
										if (substr($line, $positionInLine - strlen("</SearchResults>"), strlen("</SearchResults>")) === "</SearchResults>") {
											// einde van een artikel, voeg part toe aan parts lijst
											// wanneer partnumber niet leeg is, typisch voor allerlaatste artikel in de structuur
											if ($newPart != null && $newPart->name != "") {											
												$partsList[] = $newPart->clone();
												// clear newPart to null
												$newPart->clearPart();
											}
										}

										// <Attribute> vult een eigenschap van het part in, in functie van de index
										//        van dat attribuut binnen het part dat gelezen wordt
										if (substr($line, $positionInLine - strlen("<Attribute>") - 1, strlen("<Attribute>")) === "<Attribute>") {
											// attribuut van het artikel beginnen lezen
											$columnName = $columnHeaders[$columnIndexCounter];
											$endTagPos = strpos($line, "</Attribute>", $positionInLine - strlen("<Attribute>")) +1;
											if ($endTagPos !== false) {
												$attributeValue = trim(substr($line, $positionInLine-1, $endTagPos - $positionInLine));
												// attribuut toewijzen aan part in functie van de kolom index
												if ($columnIndexCounter == $columnIndexes["Structure Level"]) {
												    $newPart->structureLevel = $attributeValue;
													// echo "Attribute for Structure Level set to " . htmlspecialchars($attributeValue) . "<br>";
												} elseif ($columnIndexCounter == $columnIndexes["Number"]) {
												    $newPart->partNumber = $attributeValue;
													// echo "Attribute for Part number set to " . htmlspecialchars($attributeValue) . "<br>";
												} elseif ($columnIndexCounter == $columnIndexes["CAD Number"]) {
													$newPart->CADNumber = $attributeValue;
												} elseif ($columnIndexCounter == $columnIndexes["Version"]) {
													$newPart->version = $attributeValue;
													// version van artikel bevat ook view Design of Manufacturing, niet relevant voor miniMaze
													// version afkappen voor eerste haakje (open) :
													$posOpenBracket = strpos($attributeValue, "(");
													if ($posOpenBracket !== false) {
														$newPart->version = trim(substr($attributeValue, 0, $posOpenBracket));
													} else {
														$newPart->version = $attributeValue;
													}
												} elseif ($columnIndexCounter == $columnIndexes["Quantity"]) {
													// attribuut niet bijhouden op part niveau, maar bijhouden voor parent-child relatie
													$quantity = $attributeValue;
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
													$certificateType = $attributeValue;
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


                            } else {
                                echo "Fout bij upload...";
                            }
                        } 
                        else {
                            echo "Ongeldige aanvraag.";
                        }
                        ?>


					</div> <!-- class="content"-->
				</div> <!-- class="box" -->
				
				<div class="box">
					<div class="content">
						
						<h2>Parts</h2>
						<div class="table-wrapper">
							<table class="alt">
								<thead>
									<tr>
										<th>Part Number</th>
										<th>CAD Number</th>
										<th>Name</th>
										<th>Version</th>
										<th>Description</th>
										<th>Material</th>
										<th>Weight</th>
										<th>Dimensions</th>
										<th>Bew.1</th>
										<th>Bew.2</th>
										<th>Bew.3</th>
										<th>Bew.4</th>
										<th>Bew.5</th>
										<th>Attest</th>
										<th>Norm</th>
										<th>RM Number</th>
										<th>Remarks</th>
										<th>State</th>
									</tr>
								</thead>
								<tbody>
									<?php
										// Verwerking van partsList : elk part weergeven in tabel en toevoegen aan database
										foreach ($partsList as $part) {
											echo $part->ToTableRow();
											$part->addOrUpdateInDatabase($conn);
										}

										// verwerking van parent-child relaties
										foreach ($parentChildRelations as $relation) {
											$relation->addOrUpdateParentChild($conn, $relation['parentPartNumber'], $relation['parentVersion'], $relation['childPartNumber'], $relation['childVersion'], $relation['quantity'], $relation['certificateType']);
										}
										
									?>
								</tbody>
							</table>
						</div> <!-- class="table-wrapper"-->


                    </div> <!-- class="content"-->
                </div> <!-- class="box" -->

				<div class="box">
					<div class="content">
						<h2>Build part structure</h2>
						<p>Total parts imported: <?php echo count($partsList); ?></p>

						<?php

							// TODO : de parent-child relaties niet opzoeken nadat alle parts zijn toegevoegd aan de database,
							// maar tijdens het toevoegen van elk part, zodat de parent-child relaties meteen in de database
							// worden opgeslagen. Op dat moment is de quantity gekend, die niet in de partsList is opgeslagen.

							// Opbouw structuur: partsList overlopen en van elk artikel zijn parent zoeken.
							// Stored procedure gebruiken om parent-child relatie in database op te slaan
/*							$numParts = count($partsList);
							// Output buffering, flush output to browser immediately
							ob_flush();
							flush();
							$partCounter = 0;

							foreach ($partsList as $part) {
								$parentFound = false;
								// zoek parent in partsList
								if ($part->structureLevel == 0) {
									// top level part, geen parent
								}
								else {
									// parent zoeken met 1 level lager structure level
									for ($i = count($partsList) - 1; $i >= 0; $i--) {
										$potentialParent = $partsList[$i];
										if ($potentialParent->structureLevel == $part->structureLevel - 1) {
											// parent gevonden
											$parent = $potentialParent->clone();
											$parentFound = true;
											break;;
										}
									}
								}
									
								// voeg parent-child relatie toe in database via stored procedure
								
								$partCounter++;
								echo "Processing part " . $partCounter . " of " . $numParts;
								if ($parentFound) {
									echo " - Part: " . htmlspecialchars($part->partNumber) . " (Version: " . htmlspecialchars($part->version) . ") , Parent: " . htmlspecialchars($parent->partNumber) . " (Version: " . htmlspecialchars($parent->version) . ")<br>" . PHP_EOL;
										// Output buffering, flush output to browser immediately
									ob_flush();
									flush();
									// call stored procedure to add part with parent
									WTPart::addOrUpdateParentChild($conn, $parent->partNumber, $parent->version, $part->partNumber, $part->version, $part->quantity, $part->certificateType);
								}
							} // einde foreach partsList voor opzoeken parent						
							 */
							?>
					</div> <!-- class="content"-->
				</div> <!-- class="box" -->

            </div> <!-- class="inner" -->

			<!-- Update page title to show import status -->
			<script>
				document.title = "miniMaze - Import Windchill structure - Completed";
				document.getElementById("importStatus").innerText += " - Completed";
			</script>

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
