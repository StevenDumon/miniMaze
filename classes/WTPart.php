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
    public $operations = array(5)  ; // Array voor 5 bewerkingen "BR", "PO", "PL", "ZA", "ZA"
    public $RMnumber;
    public $remarks; // schuine snede, markering, ...
    public $state;


    // Constructor, runs automatically when creating an object
    public function __construct($partNumber, $CADNumber, $name, $version,$description, $material, $weight, $dimensions, $attest, $norm, $operations, $RMnumber, $remarks, $state) {
        $this->partNumber = $partNumber;
        $this->CADNumber = $CADNumber;
        $this->name = $name;
        $this->version = $version;
        $this->description = $description; // Stuklijstomschrijving
        $this->material = $material;
        $this->weight = (float) $weight;
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

        // isset vangt undefined variabelen op en vervangt door default waarde
        // wanneer die niet bestaat

        echo PHP_EOL; // start writing table row on new line for better readability of HTML source code

        $tableRowStr = "<tr>";
        $tableRowStr .= "<td>" . $this->partNumber . "</td>";
        $tableRowStr .= "<td><strong>" . $this->CADNumber . "</strong></td>";
        $tableRowStr .= "<td>" . $this->name . "</td>";
        $tableRowStr .= "<td>" . $this->version . "</td>";
        $tableRowStr .= "<td>" . $this->description . "</td>";
        $tableRowStr .= "<td>" . $this->material . "</td>";
        $tableRowStr .= "<td>" . (isset($gewicht_truncated) ? $gewicht_truncated : $this->weight) . "</td>";
        $tableRowStr .= "<td>" . $this->dimensions . "</td>";
        $tableRowStr .= "<td>" . (isset($this->operations[0]) ? $this->operations[0] : "") . "</td>";
        $tableRowStr .= "<td>" . (isset($this->operations[1]) ? $this->operations[1] : "") . "</td>";
        $tableRowStr .= "<td>" . (isset($this->operations[2]) ? $this->operations[2] : "") . "</td>";
        $tableRowStr .= "<td>" . (isset($this->operations[3]) ? $this->operations[3] : "") . "</td>";
        $tableRowStr .= "<td>" . (isset($this->operations[4]) ? $this->operations[4] : "") . "</td>";
        $tableRowStr .= "<td>" . $this->attest . "</td>";
        $tableRowStr .= "<td>" . $this->norm . "</td>";
        $tableRowStr .= "<td>" . $this->RMnumber . "</td>";
        $tableRowStr .= "<td>" . $this->remarks . "</td>";
        $tableRowStr .= "<td>" . $this->state . "</td>";
        $tableRowStr .= "</tr>";
        return $tableRowStr;
    }

    public function clone(): WTPart {
        // echo "Clone methode van WTPart aangeroepen voor part number " . $this->partNumber . "<br>";
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

    public function addOrUpdateInDatabase($conn) {

        // de combinatie van partnumber en versie is uniek, dus gebruiken we ON DUPLICATE KEY UPDATE
        // hiervoor moet er wel een unieke index op partnumber en versie in de database staan
        // SQL statement hiervoor :

        // ALTER TABLE parts ADD UNIQUE(partNumber, version);

        // Aanroepen van een stored procedure om een part toe te voegen of bij te werken:
        // call minimaze.InsertNewPart(
        //      'tst_part_update',              type 's' voor partNumber
        //      'tst_part_update',              type 's' voor CADNumber
        //      'Test Part Update',             type 's' voor Name
        //      '00.1',                         type 's' voor Version
        //      'DEMO STORED PROC',             Type 's' voor Description (stuklijstomschrijving)
        //      '8.8',                          Type 's' voor materiaal
        //      '2.5',                          Type 'd' voor gewicht
        //      'M10x60',                       Type 's' voor afmetingen
        //      'EN 4014',                      Type 's' voor Norm
        //      'BR', 'PO', 'PL', 'ZA', 'ZA',   Type 's' voor bewerkingen 1-5)
        //      'RM12345',                      Type 's' voor RMnumber
        //      'No remarks',                   Type 's' voor Remarks
        //      'Released');                    Type 's' voor State

        // SQL injection voorkomen door prepared statements te gebruiken
        $stmt = $conn->prepare("CALL minimaze.InsertNewPart(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // binding string parameters to prevent SQL injection
        $stmt->bind_param("ssssssdssssssssss",
            $this->partNumber,
            $this->CADNumber,
            $this->name,
            $this->version,
            $this->description,
            $this->material,
            $this->weight,
            $this->dimensions,
            $this->norm,
            $this->operations[0],
            $this->operations[1],
            $this->operations[2],
            $this->operations[3],
            $this->operations[4],
            $this->RMnumber,
            $this->remarks,
            $this->state
        );
        
        $stmt->execute();
        $stmt->close();
//        $conn->close();
    }

} // einde class WTPart
?>