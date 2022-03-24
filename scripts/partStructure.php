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
      // writePartRow($conn,$childID, $quantity, $partLevel+1, $numChildren);
      writePartRow($conn,$childID, $quantity, $partLevel+1);
      // eigen children opzoeken
      getChildren($conn, $childID, $partLevel+1);
    }
  }
}

function writePartRow($conn, $partID, $quantity, $partLevel) {
  $query = "SELECT Number, Version, Name FROM XML_demo.Parts WHERE PartID='$partID'";
  $result = $conn->query($query);
  // echo "writePartRow(". $partID . ")<br>";
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
    echo "<a href='part_details.php?partNumber=" . $partNumber ."&partVersion=".$partVersion."'>$partNumber</a></td><td>$partName</td><td>$quantity</td></tr>";
  }
}

function getSubparts($conn, $partID){
  $subParts=array();

  // start calling recirsuve function
  echo "Searching for children of part ID " . $partID . "<br>";
  $quantity = 1; // quantity of root part is always = 1
  getSubpartsRecursive($conn, $partID, $quantity);

  return $subParts;
}

function getSubpartsRecursive($conn, $partID, $parentQuantity){
  // function to recursively collect all parts of a root part
  // to be used to collect all parts required to launch a production order.
  // To add element at the end of the array in php : $array[] = $var;

  $query = "SELECT ChildID, Quantity FROM XML_demo.PartUsage WHERE ParentID='$partID'";
  $result = $conn->query($query);


  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $childID = $row["ChildID"];
      $quantity= $row["Quantity"];
      echo "Part " . $partID . ", # children : " . $result->num_rows . ", quantity : " . $quantity . "<br>";

      // Toevoegen aan array
      $subParts[]=childID;
      // eigen children opzoeken
      getSubpartsRecursive($conn, $childID, $quantity);
    }
  }
}

?>
