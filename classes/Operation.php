<?php
class Operation {
    public $operationShort;
    public $operationLong;

    // static methods for translating operation codes to descriptions
    public static function getOperationShortDescription($code) {
        $descriptions = [
            'BR' => 'Branden',
            'PO' => 'Ponsen',
            'PL' => 'Plooien',
            'ZA' => 'Zagen',
            'ZB' => 'Zaagboor',
            'SN' => 'Snijden',
            'LS' => 'Lasersnijden',
            'RO' => 'Rollen',
            'KL' => 'Klembank lassen',
            'VP' => 'Verspanen',
            'NG' => 'Nabehandeling - Galvaniseren',
            'NS' => 'Nabehandeling - Schilderen',
            'NZ' => 'Nabehandeling - Zwart'
        ];
        return $descriptions[$code] ?? 'Unknown Operation';
    }
}
?>