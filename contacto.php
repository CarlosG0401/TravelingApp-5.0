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
    <title>Contacto - TravelingWeb</title>
    <link rel="stylesheet" href="assets/styles/contacto.css">
</head>

<body>
    <header>
        <h2 class="logo">
            <img src="assets/images/imagen-foto-removebg-preview.png" alt="Logo" class="logo-img">
        </h2>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <a href="service.php">Service</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="contacto.php" class="active">Contacto</a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="center-text">
        <h1>¡Contáctanos!</h1>
    </div>

    <div class="contact-container">
        <div class="contact-form">
            <form action="php/contacto_enviar.php" method="post">
                <div class="input-box">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-box">
                    <textarea name="message" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="contact-btn">Send Message</button>
            </form>
        </div>

        <div class="social-media">
            <h2>Síguenos</h2>
            <a href="#" class="social-icon"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#" class="social-icon"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="#" class="social-icon"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#" class="social-icon"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
    </div>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
