<?php
include("../scripts/database_connection.php");

class WTPart {
    public $partNumber;
    public $CADNumber;
    public $name;
    public $version;
    public $description; // stuklijstomschrijving
    public $material;
    public $weight;
    public $dimensions;
    public $attest;
    public $norm;
    public $operations = array(5)  ; // Array voor 5 bewerkingen
    public $RMnumber;
    public $remarks; // schuine snede, markering, ...
    public $state;


    // Constructor, runs automatically when creating an object
    public function __construct($partNumber, $CADNumber, $name, $version,$description, $material, $weight, $dimensions, $attest, $norm, $operations, $RMnumber, $remarks, $state) {
        $this->partNumber = $partNumber;
        // echo "Constructor WTPart aangeroepen, part number is " . $partNumber . "<br>";
        $this->CADNumber = $CADNumber;
        $this->name = $name;
        $this->version = $version;
        $this->description = $description; // Stuklijstomschrijving
        $this->material = $material;
        $this->weight = $weight;
        $this->dimensions = $dimensions;
        $this->attest = $attest;
        $this->norm = $norm;
        $this->operations = $operations;
        $this->RMnumber = $RMnumber;
        $this->remarks = $remarks; // schuine snede, markering, ...
        $this->state = $state;
    }

    public function addOperation($index, $operation) {
        if ($index >= 0 && $index < 5) {
            $this->operations[$index] = $operation;
        } else {
            throw new Exception("Index out of bounds. Valid indices are 0 to 4.");
        }
    }

    public function getOperation($index) {
        if ($index >= 0 && $index < 5) {
            return $this->operations[$index];
        } else {
            throw new Exception("Index out of bounds. Valid indices are 0 to 4.");
        }
    }

    public function getAllOperations() {
        return $this->operations;
    }

    public function ToString(): string {
        return "Part Number: " . $this->partNumber . ", CAD Number: " . $this->CADNumber . ", Name: " . $this->name . ", Version: " . $this->version . ", Description: " . $this->description . ", Material: " . $this->material . ", Weight: " . $this->weight . ", Dimensions: " . $this->dimensions . ", Attest: " . $this->attest . ", Norm: " . $this->norm . ", RM Number: " . $this->RMnumber . ", Remarks: " . $this->remarks . ", State: " . $this->state;
    }

    public function ToTableRow(): string {
        $posDecimal = strpos($this->weight, '.');
        if ($posDecimal !== false) {
            $gewicht_truncated = substr($this->weight, 0, $posDecimal +3);
        }
        return "<tr><td>" . $this->partNumber . "</td><td>" . $this->CADNumber . "</td><td>" . $this->name . "</td><td>" . $this->version . "</td><td>" . $this->description . "</td><td>" . $this->material . "</td><td>" . $gewicht_truncated . "</td><td>" . $this->dimensions . "</td><td>" . $this->attest . "</td><td>" . $this->norm . "</td><td>" . $this->RMnumber . "</td><td>" . $this->remarks . "</td><td>" . $this->state . "</td></tr>";
    }

    public function clone(): WTPart {
        echo "Clone methode van WTPart aangeroepen voor part number " . $this->partNumber . "<br>";
        return new WTPart(
            $this->partNumber,
            $this->CADNumber,
            $this->name,
            $this->version,
            $this->description,
            $this->material,
            $this->weight,
            $this->dimensions,
            $this->attest,
            $this->norm,
            $this->operations,
            $this->RMnumber,
            $this->remarks,
            $this->state
        );
    }

    public function clearPart() {
        $this->partNumber = "";
        $this->CADNumber = "";
        $this->name = "";
        $this->version = "";
        $this->description = "";
        $this->material = "";
        $this->weight = "";
        $this->dimensions = "";
        $this->attest = "";
        $this->norm = "";
        $this->operations = array(5);
        $this->RMnumber = "";
        $this->remarks = "";
        $this->state = "";
    }

    public function addOrUpdateInDatabase() {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // de combinatie van partnumber en versie is uniek, dus gebruiken we ON DUPLICATE KEY UPDATE
    // hiervoor moet er wel een unieke index op partnumber en versie in de database staan
    // SQL statement hiervoor :
    // ALTER TABLE parts ADD UNIQUE(partNumber, version);


    $sql = "INSERT INTO parts (partNumber, CADNumber, name, version, description, material, weight, dimensions, attest, norm, RMnumber, remarks, state)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            CADNumber=VALUES(CADNumber), name=VALUES(name),
            version=VALUES(version), description=VALUES(description),
            material=VALUES(material), weight=VALUES(weight),
            dimensions=VALUES(dimensions), attest=VALUES(attest),
            norm=VALUES(norm), RMnumber=VALUES(RMnumber),
            remarks=VALUES(remarks), state=VALUES(state)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss",
        $this->partNumber,
        $this->CADNumber,
        $this->name,
        $this->version,
        $this->description,
        $this->material,
        $this->weight,
        $this->dimensions,
        $this->attest,
        $this->norm,
        $this->RMnumber,
        $this->remarks,
        $this->state
    );
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }
}
?>