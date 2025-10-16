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
  // echo "Searching for children of part ID " . $partID . "<br>";
  $quantity = 1; // quantity of root part is always = 1
  $whereUsed = "";
  $query = "SELECT Number FROM XML_demo.Parts WHERE PartID='$partID'";
  $result = $conn->query($query);

  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $whereUsed= $row["Number"];
      // echo "Part whereUsed starts with " . $whereUsed . "<br>";
    }
  }
  getSubpartsRecursive($conn, $partID, $quantity, $whereUsed, $subParts);

  echo "<br>";
  // echo "Returning " . count($subParts) . " items." . "<br>";

  return $subParts;
}

function getSubpartsRecursive($conn, $partID, $parentQuantity, $whereUsed, &$subParts){
  // function to recursively collect all parts of a root part
  // to be used to collect all parts required to launch a production order.
  // To add element at the end of the array in php : $array[] = $var;
  //
  // The main thing when populating an array recursively is to pass the result array by reference.
  // If you don't you are just passing a copy of the array to the next level and the copy is lost when the function returns.

  // $query = "SELECT ChildID, Quantity FROM XML_demo.PartUsage WHERE ParentID='$partID'";
  $query = "SELECT p.Number, p.Name, p.version, "
         . "p.Operation_1, p.Operation_2, p.Operation_3, p.Operation_4, p.Operation_5,"
         . "u.ChildID, u.Quantity FROM XML_demo.PartUsage u "
         . "INNER JOIN XML_demo.Parts p "
         . "ON u.ChildID = p.PartID "
         . "WHERE u.ParentID='$partID'";
  $result = $conn->query($query);


  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $childID = $row["ChildID"];
      //$childName = $row["Name"];
      $childNumber = $row["Number"];
      $quantity= $row["Quantity"];
      $operation_1= $row["Operation_1"];
      $operation_2= $row["Operation_2"];
      $operation_3= $row["Operation_3"];
      $operation_4= $row["Operation_4"];
      $operation_5= $row["Operation_5"];
      // echo "Parent part (id " . $partID . ") has " . $result->num_rows . " children, Child " . $childNumber . " quantity : " . $quantity . ". Where used " . $whereUsed . "<br>";

      // Toevoegen aan array wanneer er effectief bewerkingen uit te voeren zijn.
      // Beter alternatief : toevoegen aan array wanneer er geen verdere children zijn !
      $subParts[]=array($childID, $childNumber, $whereUsed, $quantity, $operation_1, $operation_2, $operation_3, $operation_4, $operation_5);
      // echo "part list now contains " . count($subParts) . " items." . "<br>";
      // eigen children opzoeken
      $childwhereUsed = $whereUsed . " - " . $childNumber;
      getSubpartsRecursive($conn, $childID, $quantity, $childwhereUsed, $subParts);
    }
  }
}
?>
