<html>
  <head>
    <title>Database setup</title>
    <?php include("database_connection.php"); ?>
  </head>
  <body>
    <h1>Database Setup</h1>

    <?php
      $conn = new mysqli($servername, $username, $password, $dbname);
      echo "Creating tables in XML database" . "<br>";

      // Create Table Operations
      $sql = "CREATE TABLE XML_demo.Operations (OperationsID VARCHAR(2) NOT NULL, Description VARCHAR(20) NOT NULL, PRIMARY KEY (OperationsID))";
      $result = $conn->query($sql);
      if ($result->num_rows < 1) { echo "Table Operations created" . "<br>";}

      // Populate Table Operations
      $sql = "INSERT INTO XML_demo.Operations (OperationsID, Description) "
        . "VALUES "
        . "('BR', 'Branden'), "
        . "('LS', 'Lasersnijden'), "
        . "('PL', 'Plooien'), "
        . "('ZA', 'Zagen'), "
        . "('ZB', 'Zaagboor'), "
        . "('PO', 'Ponsen'), "
        . "('AS', 'Afschuinen'), "
        . "('VP', 'Verspanen'), "
        . "('EP', 'Extern plooien'), "
        . "('RO', 'Rollen'), "
        . "('AK', 'Aankopen'), "
        . "('OA', 'Onderaanneming'), "
        . "('NZ', 'Geen nabehandeling'), "
        . "('NG', 'Galvanizeren')"
        . ";";
      $result = $conn->query($sql);
      if ($result->num_rows < 1) { echo "Operation values defined" . "<br>";}

      // Create Table 'Parts'
      $sql = "CREATE TABLE XML_demo.Parts ("
        ."PartID INT NOT NULL AUTO_INCREMENT, "
        ."Number VARCHAR(60) NOT NULL, "
        ."Name VARCHAR(60) NOT NULL, "
        ."Version VARCHAR(10) NOT NULL, "
        ."Dimension VARCHAR(45) NULL, "
        ."RM_number VARCHAR(10) NULL, "
        ."Standard VARCHAR(45) NULL, "
        ."Operation_1 VARCHAR(2) NULL, "
        ."Operation_2 VARCHAR(2) NULL, "
        ."Operation_3 VARCHAR(2) NULL, "
        ."Operation_4 VARCHAR(2) NULL, "
        ."Operation_5 VARCHAR(45) NULL, "
        ."Created VARCHAR(40) NULL, "
        . "PRIMARY KEY (PartID));";
      $result = $conn->query($sql);
      if ($result->num_rows < 1) { echo "Table Operations created" . "<br>";}

      // Create Table 'PartUsage'
      $sql = "CREATE TABLE XML_demo.PartUsage ("
        ."PartUsageID INT NOT NULL AUTO_INCREMENT, "
        ."ParentID INT NOT NULL, "
        ."ChildID INT NOT NULL, "
        ."Quantity INT NOT NULL, "
        ."Certificate VARCHAR(10) NULL, "
        . "PRIMARY KEY (PartUsageID));";
      $result = $conn->query($sql);
      if ($result->num_rows < 1) { echo "Table Parts Usage created" . "<br>";}

      // Create Table 'ImportLog'
      $sql = "CREATE TABLE XML_demo.ImportLog ("
        ."ImportID INT NOT NULL AUTO_INCREMENT, "
        ."filename VARCHAR(60) NULL, "
        ."CreateDate VARCHAR(40) NULL , "
        ."PRIMARY KEY (ImportID));";
      $result = $conn->query($sql);
      if ($result->num_rows < 1) { echo "Table Import Log created" . "<br>";}

      //$conn.close();
      echo "Finished";
      ?>

  </body>
</html>
