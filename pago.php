<?php
    session_start();

    // Verifica si los datos personales están presentes en la sesión
    if (!isset($_SESSION['nombre'])) {
        // Redirige al formulario inicial si no hay datos
        header("Location: formulario.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Pago</title>
    <link rel="stylesheet" href="assets/styles/pago.css">
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
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>
    
    <section class="zona3">
        <div class="form-container">
            <h1>Realizar Pago</h1>
            <form action="procesar_pago.php" method="post">
                <div class="form-group">
                    <label for="nombreTarjeta">Nombre en la Tarjeta</label>
                    <input type="text" id="nombreTarjeta" name="nombreTarjeta" required>
                </div>
                <div class="form-group">
                    <label for="numeroTarjeta">Número de la Tarjeta</label>
                    <input type="text" id="numeroTarjeta" name="numeroTarjeta" required>
                </div>
                <div class="form-group">
                    <label for="fechaExpiracionTarjeta">Fecha de Expiración</label>
                    <input type="text" id="fechaExpiracionTarjeta" name="fechaExpiracionTarjeta" placeholder="MM/AA" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>
                <button type="submit" class="btn-azul">Pagar</button>
            </form>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        });
    </script>
</body>
</html>
