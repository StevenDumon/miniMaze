<html>
  <head>

    <?php
      include("scripts/database_connection.php");
      include("scripts/partStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

    <title>
      Statistics <?php echo $partNumber;?>
    </title>
    <!--<link rel="stylesheet" href="stylesheets/normalize.css">-->
    <link rel="stylesheet" href="stylesheets/skeleton.css">
    <!--<link rel="stylesheet" href="stylesheets/fork-awesome.css">-->
    <link rel="stylesheet" href="stylesheets/custom.css">
  </head>
  <body>

    <h1>Parts</h1>
    <div class='container'>
      <div class='row'>

    <?php
      echo "<div class='four columns'>";
      echo "<h2>Details</h2>";

      $query = "SELECT * FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY Version";
      $result = $conn->query($query);
      echo "<p>";
      echo "Number of parts : " . $result->num_rows;
      echo "</div><!--end of class '... columns'-->";

      echo "<div class='one columns'>";
      echo "&nbsp;";
      echo "</div>";

      echo "<div class='container'><div class='row'><div class='twelve columns'>";

    ?>
  </body>
</html>
