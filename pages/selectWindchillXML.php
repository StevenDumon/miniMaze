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
			<div class="logo"><!--<a href="index.php">Hielo <span>by TEMPLATED</span></a>-->miniMaze > Import Windchill structure</div>
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
							<h2>Import</h2>
						</header>

                        <p>Importeer Multilevel BOM reports uit Windchill in de Modelstructure for BOM view, geëxporteerd als XML bestand.</p>

                        <form action="importWindchillXML.php" method="post" enctype="multipart/form-data">
                            <!--<p><input type="text" id="partNumber" name="partNumber" placeholder="Part number"></p>-->
                            <footer class="align-center">
                                <p><input type="file" name="XMLfile" accept=".xml" required></p>
                                <input type="submit" name="submit" value="Upload" class="button alt">
                            </footer>
                        </form>
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
