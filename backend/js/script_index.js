$(document).ready(function () {

$('#rut').on('input', function () {
    var rut = $(this).val();
    validateRut(rut);
});    
// Cargar regiones al cargar la página
loadRegions();
// Manejar cambios en la selección de regiones
$('#region').change(function () {
    var regionId = $(this).val();
    //alert(regionId);
    loadCommunes(regionId);
});
loadCandidates();
});

function loadRegions() {
$.ajax({
    type: 'POST',
    url: 'backend/sql/ajax.php',
    data: { action: 'getRegions' },
    success: function (response) {
        $('#region').html(response);
    }
});
}

function loadCommunes(regionId) {
$.ajax({
    type: 'POST',
    url: 'backend/sql/ajax.php',
    data: { action: 'getCommunes', regionId: regionId },
    success: function (response) {
        $('#comuna').html(response);
    }
});
}

function loadCandidates() {
$.ajax({
    type: 'POST',
    url: 'backend/sql/candidates_ajax.php',
    data: { action: 'getCandidates' },
    success: function (response) {
        $('#candidate').html(response);
    }
});
}

function validateRut(rut) {
$.ajax({
    type: 'POST',
    url: 'backend/sql/vrut_ajax.php',
    data: { action: 'validateRut', rut: rut },
    success: function (response) {
        $('#rutError').html(response);
    }
});
}

// Función para validar y enviar el voto
function submitVote() {
// Implementar lógica de validación y envío del voto usando AJAX
}
