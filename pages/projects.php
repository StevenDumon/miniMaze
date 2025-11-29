<html>
	<head>
		<?php
			include("../scripts/database_connection.php");
			$conn = new mysqli($servername, $username, $password, $dbname);
		?>

		<title>
            Projects
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
							<p>Create new project</p>
						</header>
                        <form autocomplete="off" action="../scripts/createProject.php" method="post" enctype="multipart/form-data">
                            <div class="row uniform 50%">
                                <div class="6u 12$(xsmall)">
                                    <ul class="actions small">
                                        <li><input type="text" name="projectNumber" id="projectNumber" placeholder="Project Number" required/></li>
                                        <li><input type="text" name="description" id="description" placeholder="Description" required/></li>
                                        <li><input type="text" name="client" id="client" placeholder="Client" required/></li>
                                    </ul>

                                </div>
                                <div class="6u 12$(xsmall)">
                                    <input type="submit" value="Create Project" class="button alt"/>
                                </div>
                            </div>
                        </form>

        			</div> <!-- End of content  -->
				</div> <!-- End of first box -->
			</div> <!-- End of inner -->

			<div class="inner">
				<div class="box">
					<div class="content">
						<header class="align-center">
							<p>All projects</p>
						</header>


                        <h1>All projects</h1>

                        <?php
							$query = "SELECT Number, Description, Client FROM minimaze.Projects";
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
                                            <td><a href=projectDetails.php?projectNumber=".$row['Number'].">" . $row['Number'] . "</a></td>
                                            <td>" . $row['Description'] . "</td>
                                            <td>" . $row['Client'] . "</td>
                                          </tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "<p>No projects found.</p>";
                            }
                        ?>

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
