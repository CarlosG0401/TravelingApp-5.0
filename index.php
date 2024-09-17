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


    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>