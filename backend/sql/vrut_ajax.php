<?php
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'validateRut') {
        validateRut($_POST['rut']);
    }
}

function validateRut($rut) {
    $cleanedRut = cleanRut($rut);

    if (isValidRut($cleanedRut)) {
        echo '<span id="vrut" name="vrut" style="color: green;">válido</span>';
    } else {
        echo '<span id="irut" name="irut" style="color: red;">inválido</span>';
    }
}

function cleanRut($rut) {
    // Elimina puntos y guiones, deja solo números y el dígito verificador
    $cleanedRut = preg_replace('/[^0-9kK]/', '', $rut);
    return $cleanedRut;
}

function isValidRut($rut) {
    if (empty($rut)) {
        return false;
    }

    // Divide el RUT en número y dígito verificador
    $rutNumber = substr($rut, 0, -1);
    $rutDV = strtoupper(substr($rut, -1));

    // Revierte el número del RUT
    $reversedRut = strrev($rutNumber);

    $sum = 0;
    $multiplier = 2;

    // Calcula el dígito verificador esperado
    foreach (str_split($reversedRut) as $digit) {
        $sum += $digit * $multiplier;
        $multiplier = $multiplier < 7 ? $multiplier + 1 : 2;
    }

    $expectedDV = 11 - ($sum % 11);
    $expectedDV = ($expectedDV == 11) ? 0 : (($expectedDV == 10) ? 'K' : $expectedDV);

    // Compara el dígito verificador calculado con el proporcionado
    return $rutDV == $expectedDV;
}
?>
