<!DOCTYPE HTML>
<html>
	<head>
		<title>Operator Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<?php
			include("scripts/menu.php");
      include("scripts/database_connection.php");
      //include("scripts/partStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><!--<a href="index.html">-->Production planning <!--<span>by TEMPLATED</span></a> --></div>
				<a href="#menu">Menu</a>
			</header>

			<?php writeMenu(); ?>

		<section id="" class="wrapper style2">
			<div class="inner">
				<p>INNER<p>
			</div>

			<div class="inner"> <!-- left and right margin -->
				INNER
				<div class="box"> <!-- white box background -->
					<p>BOX in INNER</>
				</div> <!-- End of box, white background -->
			</div> <!-- End of inner, left and right margins -->

			<div class="inner"> <!-- left and right margin -->
				INNER
				<div class="box"> <!-- white box background -->
					BOX
					<div class="content"> <!-- Margin between text and white box -->
					<p>CONTENT in BOX in INNER</>
					</div> <!-- End of Content -->
				</div> <!-- End of box, white background -->
			</div> <!-- End of inner, left and right margins -->

			<div class="inner"> <!-- left and right margin -->
				<div class="row 200%">
					<div class="6u 12u$(medium)">
						<div class="box"> <!-- white box background -->
							<div class="content"><p>Content in BOX in 6u$ 12u$</p></div>
						</div> <!-- End of box, white background -->
					</div> <!-- end of left column -->
					<div class="6u$ 12u$(medium)"> <!-- start of right column -->
						<div class="box"> <!-- white box background -->
							<div class="content"><p>Content in BOX in 6u$ 12u$</p></div>
						</div> <!-- End of box, white background -->
					</div> <!-- end of right column -->
				</div> <!-- End of row 200 -->
			</div> <!-- End of inner, left and right margins -->

			<div class="inner"> <!-- left and right margin -->
				<div class="row 200%">
					<div class="3u 12u$(medium)">
						<div class="box"> <!-- white box background -->
							<div class="content"><p>Content in BOX in 3u$ 12u$</p></div>
						</div> <!-- End of box, white background -->
					</div> <!-- end of left column -->
					<div class="9u$ 12u$(medium)"> <!-- start of right column -->
						<div class="box"> <!-- white box background -->
							<div class="content"><p>Content in BOX in 9u$ 12u$</p></div>
						</div> <!-- End of box, white background -->
					</div> <!-- end of right column -->
				</div> <!-- End of row 200 -->
			</div> <!-- End of inner, left and right margins -->

			<div class="inner"> <!-- left and right margin -->
				<div style="float: left; width: 33.33%;">
					<div class="box"> <!-- white box background -->
						<div class="content">Col 1</div>
					</div>
				</div>
				<div style="float: left; width: 33.33%;">
					<div class="box"> <!-- white box background -->
						<div class="content">Col 2</div>
					</div>
				</div>
				<div style="float: left; width: 33.33%;">
					<div class="box"> <!-- white box background -->
						<div class="content">Col 3</div>
					</div>
				</div>
			</div> <!-- End of inner, left and right margins -->

			<div class="inner"> <!-- left and right margin -->
				<div class="row 200%">
					<div class="box">
						<div class="6u 12u$(medium)">
								<div class="content"><p>Content in BOX in 6u$ 12u$</p></div>
							</div> <!-- end of left column -->
							<div class="6u$ 12u$(medium)"> <!-- start of right column -->
								<div class="content"><p>Content in BOX in 6u$ 12u$</p></div>
							</div> <!-- end of right column -->
						</div>
				</div> <!-- End of row 200 -->
			</div> <!-- End of inner, left and right margins -->

		<div class="inner"> <!-- left and right margin -->
			<div class="box"> <!-- white box background -->
		<!-- Elements -->
			<div class="row 200%">
				<div class="6u 12u$(medium)">

					<!-- Text stuff -->
						<h3>Text</h3>
						<p>This is <b>bold</b> and this is <strong>strong</strong>. This is <i>italic</i> and this is <em>emphasized</em>.
						This is <sup>superscript</sup> text and this is <sub>subscript</sub> text.
						This is <u>underlined</u> and this is code: <code>for (;;) { ... }</code>.
						Finally, this is a <a href="#">link</a>.</p>
						<hr />
						<header>
							<h2>Heading with a Subtitle</h2>
							<p>Lorem ipsum dolor sit amet nullam id egestas urna aliquam</p>
						</header>
						<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>

						<div class="row">
							<div class="6u 12u$(small)">
								<p>Form for Project selection</p>
							</div>
							<div class="6u$ 12u$(small)">
								<p>Form for Transmittal selection</p>
							</div>
						</div>

				</div> <!-- end of left column -->
				<div class="6u$ 12u$(medium)"> <!-- start of right column -->
					<h3>Text</h3>
					<p>This is <b>bold</b> and this is <strong>strong</strong>. This is <i>italic</i> and this is <em>emphasized</em>.
					This is <sup>superscript</sup> text and this is <sub>subscript</sub> text.
					This is <u>underlined</u> and this is code: <code>for (;;) { ... }</code>.
					Finally, this is a <a href="#">link</a>.</p>
					<hr />

					<!-- Buttons -->
						<h3>Buttons</h3>
						<ul class="actions">
							<li><a href="#" class="button special">Special</a></li>
							<li><a href="#" class="button">Default</a></li>
							<li><a href="#" class="button alt">Alternate</a></li>
						</ul>

				</div>
			</div> <!-- End of row 200 -->






							<form method="post" action="#">
								<div class="row uniform">
									<label for="cars">Choose a car:</label>
								  <select id="cars" name="cars">
								    <option value="volvo">Volvo XC90</option>
								    <option value="saab">Saab 95</option>
								    <option value="mercedes">Mercedes SLK</option>
								    <option value="audi">Audi TT</option>
								  </select>
									<label for="cars">Choose a car:</label>
								  <select id="cars" name="cars">
								    <option value="volvo">Volvo XC90</option>
								    <option value="saab">Saab 95</option>
								    <option value="mercedes">Mercedes SLK</option>
								    <option value="audi">Audi TT</option>
								  </select>

								</div> <!-- End of class = row uniform -->
							</form>



				</div>
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
