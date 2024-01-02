<?php
header("Content-Type: text/html;charset=utf-8");
include 'db.php';


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getCandidates') {
        getCandidates();
    }
}

function getCandidates() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM candidatos");
    $stmt->execute();
    $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = '<option value="">Seleccionar Candidato</option>';
    foreach ($candidates as $candidate) {
        $options .= '<option value="' . $candidate['id'] . '">' . $candidate['candidato'] . '</option>';
    }

    echo $options;
}
?>