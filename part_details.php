<html>
  <head>

    <?php
      include("scripts/database_connection.php");
      include("scripts/partStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
      $partNumber=$_GET["partNumber"];
      $partVersion=$_GET["partVersion"];
    ?>

    <!--Menu-->
     <iframe src="frames/menu.php" title="Menu" width="100%" height="70" style="border:none;" scrolling="no"></iframe>

    <title>
      Part details <?php echo $partNumber;?>
    </title>
    <!--<link rel="stylesheet" href="stylesheets/normalize.css">-->
    <link rel="stylesheet" href="stylesheets/skeleton.css">
    <!--<link rel="stylesheet" href="stylesheets/fork-awesome.css">-->
    <link rel="stylesheet" href="stylesheets/custom.css">
  </head>
  <body>

    <h1>Part details</h1>
    <div class='container'>
      <div class='row'>

    <?php
      echo "<div class='four columns'>";
      echo "<h2>Details</h2>";

      $query = "SELECT * FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY Version";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $partID = $row["PartID"];
        $partName = $row["Name"];
        $operation_1 = $row["Operation_1"];
        $operation_2 = $row["Operation_2"];
        $operation_3 = $row["Operation_3"];
        $operation_4 = $row["Operation_4"];
        $operation_5 = $row["Operation_5"];
      }

      echo "<table>";
      echo "<tr><td>Number</td><td>" . $partNumber . "</td></tr>";
      echo "<tr><td>Version</td><td>" . $partVersion . "</td></tr>";
      echo "<tr><td>Name</td><td>" . $partName . "</td></tr>";
      echo "<tr><td>Operations</td><td>";
      if ($operation_1 != "") {echo $operation_1;}
      if ($operation_2 != "") {echo " -> " . $operation_2;}
      if ($operation_3 != "") {echo " -> " . $operation_3;}
      if ($operation_4 != "") {echo " -> " . $operation_4;}
      if ($operation_5 != "") {echo " -> " . $operation_5;}
      echo "</td></tr>";
      echo "</table>";
      echo "</div><!--end of class '... columns'-->";

      echo "<div class='one columns'>";
      echo "&nbsp;";
      echo "</div>";

      echo "<div class='seven columns'>";
      echo "<h2>Versions</h2>";
      // Look for all versions of that part
      $query = "SELECT Number, Version FROM XML_demo.Parts WHERE Number='$partNumber' ORDER BY 'Version'";
      //echo $query . "<br>";
      $result = $conn->query($query);

      if ($result->num_rows > 0){

        // Write table header
        echo "<table><tr><th>Version</th><th>Date</th></tr>";

        // Loop all found versions
        while($row = $result->fetch_assoc()){
          $availableVersion = $row["Version"];
          // Date created of this available version
          $date="..."; //initial value
          $dateQuery = "SELECT Created FROM XML_demo.Parts WHERE Number='$partNumber' AND Version='$availableVersion'";
          $dateResult = $conn->query($dateQuery);
          if ($result->num_rows > 0){
            $dateRow = $dateResult->fetch_assoc();
            $date= $dateRow["Created"];
          }
          // If initial version is not specified, then use latest version
          if ($partVersion==""){$partVersion=$availableVersion;}
          echo "<tr>";
          echo "<td><a href='part_details.php?partNumber=" . $partNumber ."&partVersion=".$availableVersion."'>$availableVersion</a></td>";
          echo "<td>$date</td>";
          echo "</tr>";
        }

        // Write table end tag
        echo "</table>";
        //echo "</div><!--end of class '... columns'-->";
      }

      echo "<h2>Where used</h2>";
      //echo "<div class='container'><div class='row'><div class='twelve columns'>";

      // Look for part ID to look for link where this id is used as child ID
      $childQuery = "SELECT PartID FROM XML_demo.Parts WHERE Number='$partNumber' AND Version='$partVersion'";
      $childResult = $conn->query($childQuery);
      if ($childResult->num_rows > 0){
        $childRow = $childResult->fetch_assoc();
        $childID= $childRow["PartID"];
      }

      // INNER JOIN Query :
      // SELECT p.Number, p.Version FROM XML_demo.PartUsage u
      // INNER JOIN XML_demo.Parts p
      // ON u.parentID = p.partID
      // WHERE u.ChildID='10806';
      $parentQuery = "SELECT p.Number, p.Name, p.Version FROM XML_demo.PartUsage u "
      . "INNER JOIN XML_demo.Parts p "
      . "ON u.parentID = p.partID "
      . "WHERE u.ChildID='$childID'";
      // echo $parentQuery . "<br>";

      $parentResult = $conn->query($parentQuery);
      if ($parentResult->num_rows > 0){
        // Write table header
        echo "<table><tr><th>Number</th><th>Version</th><th>Name</th></tr>";
        while($parentRow = $parentResult->fetch_assoc()){
          $parentNumber = $parentRow["Number"];
          $parentVersion = $parentRow["Version"];
          $parentName = $parentRow["Name"];
          echo "<tr><td>$parentNumber</td><td><a href='part_details.php?partNumber=" . $parentNumber . "&version=" . $parentVersion . "'>$parentVersion</a></td><td>$parentName</td></tr>";
        }
        // Write table closing tag
        echo "</table>";
      }
      else{
        echo "No where-used info available.";
      }
      echo "</div><!--end of class '... columns'--></div><!--end of class 'Row'--></div>";


      echo "<div class='container'><div class='row'><div class='twelve columns'>";
      echo "<h2>Structure</h2>";
      // Write table header
      echo "<table><tr><th>lvl</th><th>Number</th><th>Version</th><th>Name</th><th>Qty</th></tr>";
      writePartRow($conn, $partID, $quantity="", $partLevel=0);
      $children = getChildren($conn, $partID, $partLevel=0, $numChildren=1);
      foreach($children as $child) {
        writePartRow($conn, $child);
      }

      // Write table closing tag
      echo "</table>";
      echo "<div class='container'><div class='row'><div class='twelve columns'>";

    ?>
  </body>
</html>
