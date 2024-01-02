<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" >
    <title>Sistema de Votación</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="backend/js/script_index.js"></script>
</head>
<?php
    // Al enviar el form si no se cumple con el rut, email, checkbox muestra los siguientes mensajes
    if (isset($_GET['error']) && $_GET['error'] == 'email') {
        echo '<p style="color: red;">El formato del correo electrónico no es válido. Por favor, verifica tus datos e inténtalo de nuevo.</p>';
    } elseif (isset($_GET['error']) && $_GET['error'] == 'rut') {
        echo '<p style="color: red;">El RUT ya se encuentra registrado. Por favor, verifica tus datos e inténtalo de nuevo.</p>';
    }
    if (isset($_GET['error']) && $_GET['error'] == 'enviado') {
        echo '<p style="color: green;">El voto se a realizado con exito.</p>';
    }
    if (isset($_GET['error']) && $_GET['error'] == 'checkboxes') {
        echo '<p style="color: red;">debe seleccionar minimo 2 en la seccion de como se entero de nosotros.</p>';
    }
    ?>
<body>
    <form id="votingForm" action="backend/sql/save_vote.php" method="post" style="max-width: 500px; margin: 50px auto; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center;">Formulario de Votación</h2>
        
        <div>
            <label for="name" style="display: inline-block; width: 150px; text-align: right;">Nombre y Apellido:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <br>
        
        <div>
            <label for="alias" style="display: inline-block; width: 150px; text-align: right;">Alias:</label>
            <input type="text" id="alias" name="alias" pattern="[A-Za-z0-9]{6,}" title="Debe contener al menos 6 caracteres, letras y números." required>
        </div>
        <br>

        <div>
            <label for="rut" style="display: inline-block; width: 150px; text-align: right;">RUT:</label>
            <input type="text" id="rut" name="rut" title="puede ingresar su RUT con puntos y guion o sin ellos" placeholder="">
            <label id="rutError" style="color: red;"></label>
        </div>
        <br>
        
        <div>
            <label for="email" style="display: inline-block; width: 150px; text-align: right;">Email:</label>
            <input type="text" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ejemplo: micorreo@correo.cl" required>
        </div>
        <br>

        <div>
            <label for="region" style="display: inline-block; width: 150px; text-align: right;">Región:</label>
            <select id="region" name="region" required></select>
        </div>
        <br>

        <div>
            <label for="comuna" style="display: inline-block; width: 150px; text-align: right;">Comuna:</label>
            <select id="comuna" name="comuna" required></select>
        </div>
        <br>

        <div>
            <label for="candidate" style="display: inline-block; width: 150px; text-align: right;">Candidato:</label>
            <select id="candidate" name="candidate" required></select>
        </div>
        <br>

        <div>
            <label style="display: block; margin-bottom: 10px; text-align: left;">¿Cómo se enteró de nosotros?</label>
            <div>
                <input type="checkbox" id="web" name="how[]" value="web"> Web
                <input type="checkbox" id="tv" name="how[]" value="tv"> TV
                <input type="checkbox" id="socialMedia" name="how[]" value="redes_sociales"> Redes Sociales
                <input type="checkbox" id="friends" name="how[]" value="amigos"> Amigos
            </div>
        </div>
        <br>

        <button type="submit" onclick="submitVote()" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Votar</button>
    </form>

</body>
</html>
