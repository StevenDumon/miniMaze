<?php

//include("database_connection.php");

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
      writePartRow($conn,$childID, $quantity, $partLevel+1, $numChildren);
      // eigen children opzoeken
      getChildren($conn, $childID, $partLevel+1);
    }
  }
}

function writePartRow($conn, $partID, $quantity, $partLevel, $numChildren) {
  $query = "SELECT Number, Version, Name FROM XML_demo.Parts WHERE PartID='$partID'";
  $result = $conn->query($query);
  //echo "writePartRow(". $partID . ")<br>";
  if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $partNumber= $row["Number"];
    $partVersion= $row["Version"];
    $partName= $row["Name"];
    // Write table row
    echo "<tr><td>$partLevel</td>";
    $levelMargin=10*$partLevel;
    // partlevel defines spacing before part number
    echo "<td style='padding-left:" . $levelMargin ."'>";
    // partlevel defines spacing before part number
    echo "$partNumber</td><td><a href='part_details.php?partNumber=" . $partNumber ."&partVersion=".$partVersion."'>$partVersion</a></td><td>$partName</td><td>$quantity</td></tr>";
  }
}

?>
