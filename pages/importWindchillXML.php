<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Import Windchill structure</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    <?php include("../scripts/menu.php"); ?>
	<?php
		include("../scripts/database_connection.php");
		$conn = new mysqli($servername, $username, $password, $dbname);
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

                                // Verwerk file content
                                // en voeg data toe in database

                                echo "File <strong>" . htmlspecialchars($fileName) . "</strong> ingelezen.";
								echo "<br>";
								echo "<p>File content:</p>";
								echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";

								$columnHeaders = ["Structure Level",
											      "Number",
												  "CAD Number",
												  "Version",
												  "Quantity",
												  "Name",
												  "Omschrijving stuklijst NL",
												  "BOM afmetingen",
												  "GDF_NORM",
												  "Materiaal",
												  "Attest",
												  "Gewicht",
												  "Bewerking 1 in BOM",
												  "Bewerking 2 in BOM",
												  "Bewerking 3 in BOM",
												  "Bewerking 4 in BOM",
												  "Bewerking 5 in BOM",
												  "Grondstofnummer",
												  "Snede",
												  "State"];
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
								// foreach (explode("\n", $fileContent) as $line) {
								foreach (explode("\n", $fileContent) as $line) {
									// echo htmlspecialchars($line) . "<br>";
									// elke lijn overlopen tot einde van de lijn
									$positionInLine=0;
									$lineLength = strlen($line);
									while ($positionInLine < $lineLength) {
										$char = $line[$positionInLine];
										// elk karakter overlopen tot einde van de lijn
										$positionInLine++;

										// reageren op deze tags :
									

										// <ColumnName>...</ColumnName>
										//   - kolom tellen voor attributen en
										//   - in functie van de kolomkop de index van de kolommen onthouden
										if (substr($line, $positionInLine - strlen("ColumnName") - 1, strlen("ColumnName")) === "ColumnName") {
											// kolomnaam beginnen lezen
											$endTagPos = strpos($line, "</ColumnName>", $positionInLine);
											if ($endTagPos !== false) {
												$columnName = substr($line, $positionInLine, $endTagPos - $positionInLine);
												$columnName = trim($columnName);
												// echo "Kolomnaam gevonden: " . htmlspecialchars($columnName) . "<br>";
												// kolom index zoeken
												$columnIndex = array_search($columnName, $columnHeaders);
												if ($columnIndex !== false) {
													echo "Kolomindex voor " . htmlspecialchars($columnName) . " is " . $columnIndex . "<br>";
													$columnIndexes[$columnName] = $columnIndex;
												} else {
													echo "Kolomnaam " . htmlspecialchars($columnName) . " niet herkend.<br>";
												}
												$positionInLine = $endTagPos + strlen("</ColumnName>");
											}
										}

									
										// <Object> begint een nieuw artikel
										//       Kolom index teller terug op nul zetten.
										// <Attribute> vult een eigenschap van het part in, in functie van de index
										//        van dat attribuut binnen het part dat gelezen wordt

									} // einde while lijn overlopen

								} // einde foreach lijn

								
								//Voorbeeld: parse XML
								// $xml = simplexml_load_string($fileContent);
								// if ($xml === false) {
								// 	echo "Fout bij het parsen van XML.";
								// 	exit;
								// }


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

						echo "Overzicht kolom indexes:<br>";
						echo " Kolom index voor Structure Level: " . $columnIndexes["Structure Level"] . "<br>";
						echo " Kolom index voor Number: " . $columnIndexes["Number"] . "<br>";
						echo " Kolom index voor CAD Number: " . $columnIndexes["CAD Number"] . "<br>";
						echo " Kolom index voor Version: " . $columnIndexes["Version"] . "<br>";
						echo " Kolom index voor Quantity: " . $columnIndexes["Quantity"] . "<br>";
						echo " Kolom index voor Name: " . $columnIndexes["Name"] . "<br>";
						echo " Kolom index voor Omschrijving stuklijst NL: " . $columnIndexes["Omschrijving stuklijst NL"] . "<br>";
						echo " Kolom index voor BOM afmetingen: " . $columnIndexes["BOM afmetingen"] . "<br>";
						echo " Kolom index voor GDF_NORM: " . $columnIndexes["GDF_NORM"] . "<br>";
						echo " Kolom index voor Materiaal: " . $columnIndexes["Materiaal"] . "<br>";
						echo " Kolom index voor Attest: " . $columnIndexes["Attest"] . "<br>";
						echo " Kolom index voor Gewicht: " . $columnIndexes["Gewicht"] . "<br>";
						echo " Kolom index voor Bewerking 1 in BOM: " . $columnIndexes["Bewerking 1 in BOM"] . "<br>";
						echo " Kolom index voor Bewerking 2 in BOM: " . $columnIndexes["Bewerking 2 in BOM"] . "<br>";
						echo " Kolom index voor Bewerking 3 in BOM: " . $columnIndexes["Bewerking 3 in BOM"] . "<br>";
						echo " Kolom index voor Bewerking 4 in BOM: " . $columnIndexes["Bewerking 4 in BOM"] . "<br>";
						echo " Kolom index voor Bewerking 5 in BOM: " . $columnIndexes["Bewerking 5 in BOM"] . "<br>";
						echo " Kolom index voor Grondstofnummer: " . $columnIndexes["Grondstofnummer"] . "<br>";
						echo " Kolom index voor Snede: " . $columnIndexes["Snede"] . "<br>";
						echo " Kolom index voor State: " . $columnIndexes["State"] . "<br>";
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
