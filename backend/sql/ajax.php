<?php
header("Content-Type: text/html;charset=utf-8");
include 'db.php';


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getRegions') {
        getRegions();
    } elseif ($_POST['action'] == 'getCommunes') {
        getCommunes($_POST['regionId']);
    }
}

function getRegions() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM regiones");
    $stmt->execute();
    $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = '<option value="">Seleccionar Región</option>';
    foreach ($regions as $region) {
        $options .= '<option value="' . $region['id'] . '">' . $region['region'] . '</option>';
    }

    echo $options;
}

function getCommunes($regionId) {
    global $pdo;
    
    // Obtener ID de provincias asociadas a la región
    $stmt = $pdo->prepare("SELECT id FROM provincias WHERE region_id = :region_id");
    $stmt->bindParam(':region_id', $regionId, PDO::PARAM_INT);
    $stmt->execute();
    $provinceIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($provinceIds)) {
        echo '<option value="">No hay comunas disponibles</option>';
        return;
    }

    // Construir la lista de IDs de provincias para la consulta
    $provinceIdsList = implode(',', $provinceIds);

    // Obtener comunas asociadas a las provincias
    $stmt = $pdo->prepare("SELECT * FROM comunas WHERE provincia_id IN ($provinceIdsList)");
    $stmt->execute();
    $communes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = '<option value="">Seleccionar Comuna</option>';
    foreach ($communes as $comuna) {
        $options .= '<option value="' . $comuna['id'] . '">' . $comuna['comuna'] . '</option>';
    }

    echo $options;
}

?>
