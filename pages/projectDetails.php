<html>
	<head>
		<?php
			include("../scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
		?>

		<title>
            Project Details - <?php echo $_GET["projectNumber"]; ?>
        </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
        <?php include("../scripts/menu.php"); ?>
	</head>
	<body class="subpage">

		<!-- Header -->
		<header id="header">
			<div class="logo"></div>
			<a href="#menu">Menu</a>
		</header>

		<?php writeMenu(); ?>


		<!-- One -->
		<section id="one" class="wrapper style2">
			<div class="inner">
				<div class="box">
					<div class="content">
						<header class="align-center">
							<p>Project Information</p>
						</header>


                        <?php
							$query = "SELECT Number, Description, Client FROM minimaze.Projects WHERE Number='" . $_GET["projectNumber"] . "'";
                            $result = $conn->query($query);
                            if ($result && $result->num_rows > 0) {
                                echo "<table border='1'>
                                        <tr>
                                            <th>Project Number</th>
                                            <th>Description</th>
                                            <th>Client</th>
                                        </tr>";
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row['Number'] . "</td>
                                            <td>" . $row['Description'] . "</td>
                                            <td>" . $row['Client'] . "</td>
                                          </tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "<p>Project not found.</p>";
                            }
                        ?>

        			</div> <!-- End of content  -->
				</div> <!-- End of first box -->
			</div> <!-- End of inner -->

			<div class="inner">
				<div class="box">
					<div class="content">
						<header class="align-center">
							<p>Project Transmittals</p>
						</header>

                        <p>Transmittals associated with this project:</p>


        			</div> <!-- End of content  -->
				</div> <!-- End of first box -->
			</div> <!-- End of inner -->

            <div class="inner">
				<div class="box">
					<div class="content">
						<header class="align-center">
							<p>Project Production orders</p>
						</header>

                        <p>Production orders associated with this project:</p>

        			</div> <!-- End of content  -->
				</div> <!-- End of first box -->
			</div> <!-- End of inner -->


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
