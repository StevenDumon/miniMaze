<?php
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
}
?>