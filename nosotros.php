<?php
session_start();
if(isset($_SESSION['user'])){
    header("location: bienvenida.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - TravelingWeb</title>
    <link rel="stylesheet" href="assets/styles/nosotros.css">
</head>

<body>
    <header>
        <h2 class="logo">
            <img src="assets/images/imagen-foto-removebg-preview.png" alt="Logo" class="logo-img">
        </h2>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <a href="service.php">Service</a>
            <a href="nosotros.php" class="active">Nosotros</a>
            <a href="contacto.php">Contacto</a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="center-text">
        <h1>Sobre Nosotros</h1>
        <p>TravelingWeb nació con el propósito de revolucionar la planificación de viajes. Fundada en 2023, la empresa fue creada por un equipo apasionado por los viajes y la tecnología. Desde sus inicios, nuestra misión ha sido simplificar la búsqueda y reserva de viajes, ofreciendo una experiencia intuitiva y eficiente.</p>

        <p>Con el tiempo, TravelingWeb ha evolucionado, agregando nuevas funciones y servicios para satisfacer las necesidades de los viajeros. Nuestra plataforma ahora incluye herramientas avanzadas para planificación de itinerarios, recomendaciones personalizadas y soporte en tiempo real, con un alcance global y soporte en múltiples idiomas.</p>

        <p>Nos enorgullece nuestro compromiso con la innovación y la sostenibilidad. Invertimos continuamente en nuevas tecnologías para mejorar nuestros servicios y colaboramos con socios que comparten nuestra visión de un turismo responsable. Nuestro equipo de atención al cliente está siempre dispuesto a ayudar, asegurando que cada viaje sea una experiencia positiva.</p>

        <p>TravelingWeb sigue creciendo con una visión clara para el futuro: liderar el sector del turismo en línea mediante la excelencia en la experiencia del usuario y la innovación constante.</p>
    </div>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
