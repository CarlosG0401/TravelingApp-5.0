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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - TravelingWeb</title>
    <link rel="stylesheet" href="assets/styles/styles.css">
</head>
<body>

<header>
    <h2 class="logo">
        <img src="assets/images/imagen-foto-removebg-preview.png" alt="Logo" class="logo-img">
    </h2>
    <nav class="navigation">
        <a href="#">Home</a>
        <a href="#">Service</a>
        <a href="#">Nosotros</a>
        <a href="#">Contacto</a>
        <?php
        if(isset($_SESSION['user'])) {
            // Muestra el nombre de usuario y la opción de cerrar sesión si está iniciada
            echo '<span class="header-user" style="color: white;">Bienvenido, ' . $_SESSION['user'] . '</span>';
            echo '<a href="php/cerrar_session.php">Cerrar sesión</a>';
        }
        ?>
    </nav>
</header>

<div class="center-text">
    <h1>¡Aquí es dónde empieza tú aventura!</h1>
</div>

<div class="search-container">
    <form class="search-form">
        <input type="text" placeholder="Lugar de Origen" class="search-input">
        <input type="text" placeholder="Lugar de Destino" class="search-input">
        <input type="date" class="search-input">
        <input type="number" placeholder="Cantidad de Personas" class="search-input">
        <button type="submit" class="search-btn">Buscar</button>
    </form>
</div>

<script src="assets/script/scripts.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>