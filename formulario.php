<?php
    include 'php/conexion_be.php';

    // Verificamos que el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Datos personales
        $nombre = mysqli_real_escape_string($conexion, isset($_POST['nombre']) ? $_POST['nombre'] : '');
        $apellido = mysqli_real_escape_string($conexion, isset($_POST['apellido']) ? $_POST['apellido'] : '');
        $edad = mysqli_real_escape_string($conexion, isset($_POST['edad']) ? $_POST['edad'] : '');
        $email = mysqli_real_escape_string($conexion, isset($_POST['email']) ? $_POST['email'] : '');
        $sexo = mysqli_real_escape_string($conexion, isset($_POST['sexo']) ? $_POST['sexo'] : '');
        $fecha_nacimiento = mysqli_real_escape_string($conexion, isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : '');
        $nacionalidad = mysqli_real_escape_string($conexion, isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : '');

        // Insertar datos personales en la tabla datos_personales
        $query_personales = "INSERT INTO datos_personales (nombre, apellido, edad, email, sexo, fecha_nacimiento, nacionalidad) VALUES ('$nombre', '$apellido', '$edad', '$email', '$sexo', '$fecha_nacimiento', '$nacionalidad')";

        if(mysqli_query($conexion, $query_personales)){
            $datos_personales_id = mysqli_insert_id($conexion);

            if($nacionalidad == 'chilena'){
                // Documentación para nacionalidad chilena
                $tipo_documento = mysqli_real_escape_string($conexion, isset($_POST['documentoChilena']) ? $_POST['documentoChilena'] : '');
                $fecha_emision = mysqli_real_escape_string($conexion, isset($_POST['fechaEmisionChilena']) ? $_POST['fechaEmisionChilena'] : '');
                $fecha_expiracion = mysqli_real_escape_string($conexion, isset($_POST['fechaExpiracionChilena']) ? $_POST['fechaExpiracionChilena'] : '');
                $tipo_visa = mysqli_real_escape_string($conexion, isset($_POST['tipoVisaChilena']) ? $_POST['tipoVisaChilena'] : '');
                $nro_id = mysqli_real_escape_string($conexion, isset($_POST['nroIDChilena']) ? $_POST['nroIDChilena'] : '');
                $nro_documento = mysqli_real_escape_string($conexion, isset($_POST['nroDocumentoChilena']) ? $_POST['nroDocumentoChilena'] : '');
                $consejos_viaje = isset($_POST['consejosViajeChilena']) ? 1 : 0;

                $fecha_emision_vw = $tipo_visa == 'visa_waiver' && isset($_POST['fechaEmisionVW']) ? $_POST['fechaEmisionVW'] : null;
                $fecha_expiracion_vw = $tipo_visa == 'visa_waiver' && isset($_POST['fechaExpiracionVW']) ? $_POST['fechaExpiracionVW'] : null;

                // Insertar datos de documentación para nacionalidad chilena
                $query_documentacion = "INSERT INTO documentacion (datos_personales_id, tipo_documento, fecha_emision, fecha_expiracion, tipo_visa, fecha_emision_vw, fecha_expiracion_vw, nro_id, nro_documento, consejos_viaje)
                                        VALUES ('$datos_personales_id', '$tipo_documento', '$fecha_emision', '$fecha_expiracion', '$tipo_visa', 
                                        " . ($fecha_emision_vw ? "'$fecha_emision_vw'" : "NULL") . ", 
                                        " . ($fecha_expiracion_vw ? "'$fecha_expiracion_vw'" : "NULL") . ", '$nro_id', '$nro_documento', '$consejos_viaje')";
                
                if(mysqli_query($conexion, $query_documentacion)){
                    echo "Datos insertados correctamente";
                } else {
                    echo "Error al insertar datos de documentación: ". mysqli_error($conexion);
                }
            } elseif($nacionalidad == 'extranjera') {
                // Documentación para nacionalidad extranjera
                $extra_nacionalidad = mysqli_real_escape_string($conexion, isset($_POST['extraNacionalidad']) ? $_POST['extraNacionalidad'] : '');
                $tipo_documento = mysqli_real_escape_string($conexion, isset($_POST['documento']) ? $_POST['documento'] : '');
                $fecha_emision = mysqli_real_escape_string($conexion, isset($_POST['fechaEmision']) ? $_POST['fechaEmision'] : '');
                $fecha_expiracion = mysqli_real_escape_string($conexion, isset($_POST['fechaExpiracion']) ? $_POST['fechaExpiracion'] : '');
                $tipo_visa = mysqli_real_escape_string($conexion, isset($_POST['tipoVisa']) ? $_POST['tipoVisa'] : '');
                $nro_id = mysqli_real_escape_string($conexion, isset($_POST['nroID']) ? $_POST['nroID'] : '');
                $nro_documento = mysqli_real_escape_string($conexion, isset($_POST['nroDocumento']) ? $_POST['nroDocumento'] : '');
                $consejos_viaje = isset($_POST['consejosViaje']) ? 1 : 0;

                // Insertar datos de documentación para nacionalidad extranjera
                $query_documentacion = "INSERT INTO documentacion (datos_personales_id, tipo_documento, fecha_emision, fecha_expiracion, tipo_visa, nro_id, nro_documento, consejos_viaje) VALUES ('$datos_personales_id', '$tipo_documento', '$fecha_emision', '$fecha_expiracion', '$tipo_visa', '$nro_id', '$nro_documento', '$consejos_viaje')";
                
                if(mysqli_query($conexion, $query_documentacion)){
                    echo "Datos insertados correctamente";
                } else {
                    echo "Error al insertar datos de documentación: ". mysqli_error($conexion);
                }
            }
        } else {
            echo "Error al insertar datos personales: ". mysqli_error($conexion);
        }

        mysqli_close($conexion);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Datos Personales</title>
    <link rel="stylesheet" href="assets/styles/formulario.css">
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
    
    <section class="zona1">
        <div class="form-container">
            <h1>Datos Personales</h1>
            <form id="personalForm" action="formulario_documentacion.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo">
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>
                <div class="form-group">
                    <label for="nacionalidad">Nacionalidad</label>
                    <select id="nacionalidad" name="nacionalidad" onchange="toggleForm()">
                        <option value="chilena">Chilena</option>
                        <option value="extranjera">Extranjera</option>
                    </select>
                </div>
                <button type="submit" class="btn-azul">Avanzar</button>
            </form>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        });

        function toggleForm(){
            var nacionalidad = document.getElementById("nacionalidad").value;
            var extraFormChilena = document.getElementById("extraFormChilena");
            var extraFormExtranjera = document.getElementById("extraFormExtranjera");
            var submitButton = document.getElementById("submitButton");
            
            if(nacionalidad === "chilena"){
                extraFormChilena.style.display = "block";
                extraFormExtranjera.style.display = "none";
                submitButton.style.display = "none";
            } else if(nacionalidad === "extranjera"){
                extraFormChilena.style.display = "none";
                extraFormExtranjera.style.display = "block";
                submitButton.style.display = "none";
            } else {
                extraFormChilena.style.display = "none";
                extraFormExtranjera.style.display = "none";
                submitButton.style.display = "block";
            }
        }

        function toggleVisaWaiverFields() {
            var tipoVisa = document.getElementById("tipoVisaChilena").value;
            var visaWaiverFields = document.getElementById("visaWaiverFields");
            
            if(tipoVisa === "visa_waiver"){
                visaWaiverFields.style.display = "block";
            } else {
                visaWaiverFields.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function(){
            toggleForm();  // To show/hide forms based on default selection
        });
    </script>
</body>
</html>

