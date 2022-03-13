<!DOCTYPE HTML>
<html>
	<head>
		<title>miniMaze test autocomplete</title>
		<?php
			include("scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
		?>
	</head>
	<body>
		<?php
			$query = "SELECT DISTINCT Number FROM XML_demo.Parts";
			$result = $conn->query($query);
			echo "<br>Option list contains " . $result->num_rows . " autocomplete options.";
		?>

		<!--Make sure the form has the autocomplete function switched off:-->
		<form autocomplete="off" action="part_details.php" method="get" enctype="multipart/form-data">
			<input type="text" id="partNumber" name="partNumber" placeholder="Part number">
			<input type="submit" value="Search" class="button alt">
		</form>

		<!-- Autocomplete -->
		<script src="scripts/autoComplete.js"></script>
		<script>
			<?php
				$query = "SELECT DISTINCT Number FROM XML_demo.Parts ORDER BY Number";
				$result = $conn->query($query);
				$numPart=0; // use counter to avoid printing comma before first result

				if ($result->num_rows > 0){
					// write array var declaration
					echo 'var parts = [';
					echo '"option 1"';

//								        while($row = $result->fetch_assoc()){
//													$numPart++;
//								          $partNumber = $row["Number"];
//													if ($numPart!=1){echo ",";}
//								         	echo '"' . $partNumber . '"';
//								        } // end loop all results

											// write array variable closing
					echo ', "option 4"';
					echo "];";
					} // end if num_rows > 0
					// end adding parts to textfield autocomplete
			?>
			autocomplete(document.getElementById("partNumber"), parts, 100);
		</script>
	</body>
</html>
