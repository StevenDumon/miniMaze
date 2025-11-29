<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze - Create New Project</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />

		<?php
			include("database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);

			// retrieve incoming parameters :

			//Project number
			if( $_POST["projectNumber"] ) {
				$projectNumber = $_POST["projectNumber"];
			} else {
                $projectNumber = "";
            }

            // Description
            if( $_POST["description"] ) {
                $description = $_POST["description"];
            } else {
                $description = "";
            }
            // Client
            if( $_POST["client"] ) {
                $client = $_POST["client"];
            } else {
                $client = "";
            }

			?>

	</head>
	<body class="subpage">

		<!-- Header -->
		<header id="header">
			<div class="logo">Create New Project</div>
		</header>

		<div class="inner">
			<div class="box">
				<div class="content">
					<div class="row uniform">
						<div class="6u 12u$(xsmall)">

							<ul>
								<li>Project number : <?php echo $projectNumber; ?></li>
                                <li>Description : <?php echo $description; ?></li>
                                <li>Client : <?php echo $client; ?></li>
							</ul>

							<?php
								// Controleer of er al een rproject bestaat met het nummer
								// waarvoor nu een project zou moeten aangemaakt worden !
								$projectExists=false;

								$query = "SELECT Number FROM Projects WHERE Number='" . $projectNumber . "'";
								$result = $conn->query($query);

								if ($result->num_rows > 0){
									echo "Project bestaat reeds met nummer " . $projectNumber . "<br>";
									$projectExists=true;
								} // end if num_rows > 0
							?>

						</div>
						<div class="6u$ 12u$(xsmall)">
							<!--show 'back' button only if new project was created -->
							<?php
								if ($projectExists==false){
									echo "<a href='javascript:history.back()' class='button'>Back</a>";
								}
							 ?>
						</div>
					</div> <!-- end of row uniform -->
					<?php
						if ($projectExists==false){
							// Add production order to table with production orders
							// Default value voor CreatedDate is ingesteld als CURRENT_TIMESTAMP
							// Actual start date blijft nog open bij creatie production order.

							echo "Create Project." . "<br>";
                            $stmt = $conn->prepare("INSERT INTO Projects(Number, Description, Client) VALUES (?, ?, ?)");

                            // binding string parameters to prevent SQL injection
                            $stmt->bind_param("sss",
                                $projectNumber,
                                $description,
                                $client
                            );
        
                            $stmt->execute();
                            $stmt->close();

						} // end if production order nog niet bestaat
					?>
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
