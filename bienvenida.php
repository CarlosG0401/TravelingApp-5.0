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

<img src="assets/images/imagen-agencia.jpeg" alt="Imagen-Agencia" class="info-image">
<img src="assets/images/aeroporto-santiago-chile.jpeg" alt="Imagen-Santiago" class="imagen-santiago">
<body>

<header>
    <h2 class="logo">
        <img src="assets/images/imagen-foto-removebg-preview.png" alt="Logo" class="logo-img">
    </h2>
    <nav class="navigation">
        <a href="#">Home</a>
        <a href="service.php">Service</a>
        <a href="nosotros.php">Nosotros</a>
        <a href="contacto.php">Contacto</a>
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
    <form class="search-form" action="buscar_viajes.php" method="post">
        <input type="text" name="origen" placeholder="Lugar de Origen" class="search-input" required>
        <input type="text" name="destino" placeholder="Lugar de Destino" class="search-input" required>
        <input type="date" name="fecha_inicio" class="search-input" required>
        <input type="date" name="fecha_fin" class="search-input" required>
        <button type="submit" class="search-btn">Buscar</button>
    </form>
</div>

<div class="info-boxes">
        <div class="info-box">
            <h3>¿Tienes tus documentos al día?</h3>
            <p>Con nosotros puedes revisar si cuentas con los requisitos necesarios para entrar a un país de su elección.</p>
        </div>
        <div class="info-box">
            <h3>¿Dudas con tu compra?</h3>
            <p>Nosotros te asesoramos a escoger el precio y el mejor trayecto para tu tranquilidad.</p>
        </div>
        <div class="info-box">
            <h3>¿Eres chileno o extranjero?</h3>
            <p>Sin importar tu nacionalidad y estatus que tengas dentro de Chile, entregamos el mejor servicio posible para tu tranquilidad.</p>
        </div>
    </div>

    <div class="exchange-container">
        <div class="animated-exchange">
            <div class="exchange-item">
                <img src="assets/images/union.jpeg" alt="Euro" class="flag">
                <span class="exchange-rate">1 EUR = 850 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/united.png" alt="Estados Unidos" class="flag">
                <span class="exchange-rate">1 USD = 800 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/england.png" alt="Libra" class="flag">
                <span class="exchange-rate">1 GBP = 1.200 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/bandera-de-brasil.jpg" alt="Real" class="flag">
                <span class="exchange-rate">1 BRL = 167 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/argentina.png" alt="Peso Arg" class="flag">
                <span class="exchange-rate">1 ARS = 0,93 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/colombia.png" alt="Peso Col" class="flag">
                <span class="exchange-rate">1 COL = 0,21 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/peru.png" alt="Sol Peru" class="flag">
                <span class="exchange-rate">1 PEN = 241 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/union.jpeg" alt="Euro" class="flag">
                <span class="exchange-rate">1 EUR = 850 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/united.png" alt="Estados Unidos" class="flag">
                <span class="exchange-rate">1 USD = 800 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/england.png" alt="Libra" class="flag">
                <span class="exchange-rate">1 GBP = 1.200 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/bandera-de-brasil.jpg" alt="Real" class="flag">
                <span class="exchange-rate">1 BRL = 167 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/argentina.png" alt="Peso Arg" class="flag">
                <span class="exchange-rate">1 ARS = 0,93 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/colombia.png" alt="Peso Col" class="flag">
                <span class="exchange-rate">1 COL = 0,21 CLP</span>
            </div>
            <div class="exchange-item">
                <img src="assets/images/peru.png" alt="Sol Peru" class="flag">
                <span class="exchange-rate">1 PEN = 241 CLP</span>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="address-section">
                <p>TravelingWeb</p>
                <p class="address">Dirección: Av. Valle del Norte 123, Santiago, Chile</p>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.3025193668946!2d-70.62186111612631!3d-33.389270904863324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c8a91e528b09%3A0xaecac912421031a7!2sAv.%20del%20Parque%2C%20Huechuraba%2C%20Regi%C3%B3n%20Metropolitana!5e0!3m2!1ses-419!2scl!4v1727643079086!5m2!1ses-419!2scl" 
                    width="200" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="social-icons">
                <a href="#"><img src="assets/images/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="assets/images/gorjeo.png" alt="Twitter"></a>
                <a href="#"><img src="assets/images/instagram.png" alt="Instagram"></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; TravelingWeb. Todos los derechos reservados.</p>
            <p style="margin-top: 10px;">"Comprometidos con la calidad y el servicio desde 2024."</p>
            <p>Contacto: <a href="mailto:info@tuempresa.com" style="color: #ccc;">info@travelingweb.com</a> | Teléfono: +22 444 663</p>
            <p><a href="faq.html" style="color: #ccc; text-decoration: none;">Preguntas Frecuentes</a> | <a href="soporte.html" style="color: #ccc; text-decoration: none;">Soporte Técnico</a></p>
            <p><a href="terminos.html" style="color: #ccc; text-decoration: none;">Términos y Condiciones</a> | <a href="privacidad.html" style="color: #ccc; text-decoration: none;">Política de Privacidad</a></p>

        </div>
    </footer>

<script src="assets/script/scripts.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>