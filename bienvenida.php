<?php

    session_start();
    if (!isset($_SESSION["user"])){
        echo'
            <script>
                alert("Por favor, debes iniciar sesión.");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - TravelingWeb</title>
</head>
<body>
    <h1>¡Bienvenido a TravelingWeb!</h1>
    <a href="php/cerrar_session.php">Cerrar sesión</a>

</body>
</html>