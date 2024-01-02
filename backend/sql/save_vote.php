<?php
include 'db.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $name = $_POST['name'];
    $alias = $_POST['alias'];
    $rut = str_replace(['.', '-'], '', $_POST['rut']);  // Limpiar el RUT de puntos y guiones
    $email = $_POST['email'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidate = $_POST['candidate'];
    $how = isset($_POST['how']) ? (array)$_POST['how'] : [];  // Procesa los checkboxes

    // Valida seleccion 2 checkbox
    if (count($how) < 2) {
        header("Location: ../../index.php?error=checkboxes"); // Redirige de vuelta a la página del formulario con el mensaje de error
        exit;
    }
    // Valida el formato del correo electrónico en el lado del servidor
    if (!isValidEmail($email)) {
        header("Location: ../../index.php?error=email"); // Redirige de vuelta a la página del formulario con el mensaje de error
        exit;
    }

    // Valida que el RUT no esté ya registrado
    if (isRutRegistered($rut)) {
        header("Location: ../../index.php?error=rut"); // Redirige de vuelta a la página del formulario con el mensaje de error
        exit;
    }


    // Inserta los datos en la base de datos
    $stmt = $pdo->prepare("INSERT INTO votos (nombre, alias, rut, email, region, comuna, candidato, como_se_entero) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $alias, $rut, $email, $region, $comuna, $candidate, implode(', ', (array)$how)]);

    header("Location: ../../index.php?error=enviado"); // Redirige a página éxito
    exit;
}
//Funcion de Validar email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
//funcion valida registros de rut
function isRutRegistered($rut) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE rut = ?");
    $stmt->execute([$rut]);
    $count = $stmt->fetchColumn();

    return $count > 0;
}
?>
