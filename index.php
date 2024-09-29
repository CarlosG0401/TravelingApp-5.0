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
    <title>TravelingWeb</title>
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
            <button class="btnLogin-popup">Login</button>
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

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close-circle-sharp"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="php/login_usuario_be.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-sharp"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed-sharp"></ion-icon>
                            </span>
                            <input type="password" name="password" required>
                            <label>Contraseña</label>
                        </div>
                        <div class="remember-forgot">
                            <label><input type="checkbox">Recuérdame</label>
                            <a href="#">¿Olvidó contraseña?</a>
                        </div> 
                        <button type="submit" class="btn">Login</button>
                        <div class="login-register">
                        <p>¿No tienes cuenta?<a href="#" class="register-link">Registrarme</a></p>
                    </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registro</h2>
            <form action="php/registro_usuario_be.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-circle-sharp"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Usuario</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-sharp"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed-sharp"></ion-icon>
                            </span>
                            <input type="password" name="password" required>
                            <label>Contraseña</label>
                        </div>
                        <div class="remember-forgot">
                            <label><input type="checkbox">Estoy de acuerdo con los términos y condiciones</label>
                            
                        </div> 
                        <button type="submit" class="btn">Register</button>
                        <div class="login-register">
                        <p>¿Ya tienes una cuenta?<a href="#" class="login-link">Login</a></p>
                    </div>
            </form>
        </div>
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



    


    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>