<html>
  <head>

    <?php
      include("scripts/database_connection.php");
      //include("scripts/porStructure.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
      $productionOrderNumber=$_GET["productionOrdeNumber"];

      function getChildren($conn, $partID, $partLevel){
        //echo "Searching for children of part ID " . $partID . "<br>";
        //Initializations
        $query = "SELECT ChildID, Quantity FROM XML_demo.PartUsage WHERE ParentID='$partID'";

        $parentResult = $conn->query($query);
        //echo "No. children : " . $parentResult->num_rows . "<br>";
        if ($parentResult->num_rows > 0){
          while($parentRow = $parentResult->fetch_assoc()){
            $childID = $parentRow["ChildID"];
            $quantity= $parentRow["Quantity"];
            $numChildren=$parentResult->num_rows;
            // Toevoegen aan tabel
            writeProductionPartRow($conn,$childID, $quantity, $partLevel+1, $numChildren);
            // eigen children opzoeken
            getChildren($conn, $childID, $partLevel+1);
          }
        }
      }

      function writeProductionPartRow($conn, $partID, $quantity, $partLevel, $numChildren) {
        $query = "SELECT * FROM XML_demo.Parts WHERE PartID='$partID'";
        $result = $conn->query($query);
        if ($result->num_rows > 0){
          $row = $result->fetch_assoc();
          $partNumber= $row["Number"];
          //$partVersion= $row["Version"];
          $partName= $row["Name"];
          $operation_1=$row["Operation_1"];
          $operation_2=$row["Operation_2"];
          $operation_3=$row["Operation_3"];
          $operation_4=$row["Operation_4"];
          $operation_5=$row["Operation_5"];
          // Write table row
          echo "<tr><td>$partLevel</td>";
          $levelMargin=10*$partLevel;
          // partlevel defines spacing before part number
          echo "<td style='padding-left:" . $levelMargin ."'>";
          // partlevel defines spacing before part number
          echo "<a href='part_details.php?partNumber=" . $partNumber ."&partVersion=".$partVersion."'>$partNumber</a></td><td>$partName</td><td>$quantity</td>";
          echo "<td>$operation_1</td>";
          echo "<td>$operation_2</td>";
          echo "<td>$operation_3</td>";
          echo "<td>$operation_4</td>";
          echo "<td>$operation_5</td>";
          echo "</tr>";
        }
      }
    ?>

    <!--Menu-->
    <iframe src="frames/menu.php" title="Menu" width="100%" height="70" style="border:none;" scrolling="no"></iframe>

    <title>
      Production order details <?php echo $productionOrderNumber;?>
    </title>
    <!--<link rel="stylesheet" href="stylesheets/normalize.css">-->
    <link rel="stylesheet" href="stylesheets/skeleton.css">
    <!--<link rel="stylesheet" href="stylesheets/fork-awesome.css">-->
    <link rel="stylesheet" href="stylesheets/custom.css">
  </head>
  <body>

    <h1>Production order : <?php echo $productionOrderNumber; ?> </h1>
    <div class='container'>
      <div class='row'>

    <?php
      echo "<div class='four columns'>";

      $query = "SELECT Name, PartID FROM XML_demo.Parts WHERE Number='$productionOrderNumber' ORDER BY Version";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $partID = $row["PartID"];
        $partName = $row["Name"];
      }
      echo "<h2>".$partName."</h2>";
      echo "</div><!--end of class '... columns'-->";
      echo "</div><!--end of class row-->";
      echo "</div><!--end of class container-->";

      echo "<div class='container'><div class='row'><div class='twelve columns'>";
      // Write table header
      echo "<table><tr>";
      echo "<th rowspan='2'>lvl</th>";
      echo "<th rowspan='2'>Number</th>";
      echo "<th rowspan='2'>Name</th>";
      echo "<th rowspan='2'>Qty</th>";
      echo "<th rowspan='1' colspan='5'>Operations</th>";
      echo "</tr>";
      echo "<tr><th>B1</th><th>B2</th><th>B3</th><th>B4</th><th>B5</th></tr>";

      writeProductionPartRow($conn, $partID, $quantity="", $partLevel=0);
      $children = getChildren($conn, $partID, $partLevel=0, $numChildren=1);
      foreach($children as $child) {
        writeProductionPartRow($conn, $child);
      }

      // Write table closing tag
      echo "</table>";
      echo "<div class='container'><div class='row'><div class='twelve columns'>";

    ?>
  </body>
</html>
