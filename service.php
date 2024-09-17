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
    <title>Service - TravelingWeb</title>
    <link rel="stylesheet" href="assets/styles/service.css">
</head>

<body>
    <header>
        <h2 class="logo">
            <img src="assets/images/imagen-foto-removebg-preview.png" alt="Logo" class="logo-img">
        </h2>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <a href="service.php" class="active">Service</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="contacto.php">Contacto</a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="service-content">
        <div class="text-container">
            <h1>Nuestro Servicio</h1>
            <p>En <strong>TravelingWeb</strong>, transformamos tu experiencia de viaje en una aventura sin preocupaciones. Nuestra plataforma no solo te ofrece una búsqueda ágil y precisa de vuelos y pasajes, sino que también te proporciona recomendaciones personalizadas para evitar errores comunes en tu documentación. Imagina tener un asistente de viaje en tu bolsillo, que te guía con consejos prácticos para que cada etapa de tu viaje sea perfecta. Desde la reserva de tu vuelo hasta los detalles de última hora, estamos aquí para asegurarnos de que disfrutes cada momento de tu travesía con total tranquilidad. ¡Explora, reserva y viaja con confianza con TravelingWeb!</p>
        </div>
        <div class="image-travel">
            <img src="assets/images/image-airport.jpeg" alt="Travel Image">
        </div>
    </div>
    


    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
