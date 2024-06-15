<?php

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
            <form id="personalForm">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido">
                </div>
                <div class="form-group">
                    <label for="edad">Edad</label>
                        <input type="number" id="edad" name="edad">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
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
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento">
                </div>
                <div class="form-group">
                    <label for="nacionalidad">Nacionalidad</label>
                    <select id="nacionalidad" name="nacionalidad" onchange="toggleForm()">
                        <option value="chilena">Chilena</option>
                        <option value="extranjera">Extranjera</option>
                    </select>
                </div>
                <button type="submit" id="submitButton">Enviar</button>
            </form>
        </div>
    </section>
    <section class="zona2">
        <div id="extraForm" class="form-container extra-form-container" style="display: none;">
            <h2>Documentación</h2>
            <form>
                <div class="form-group">
                    <label for="extraNacionalidad">Nacionalidad</label>
                    <select id="extraNacionalidad" name="extraNacionalidad">
                        <option value="venezuela">Venezuela</option>
                        <option value="colombia">Colombia</option>
                        <option value="paraguay">Paraguay</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <select id="documento" name="documento">
                    <option value="rut">RUT</option>
                    <option value="pasaporte">Pasaporte</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaEmision">Fecha de Emisión</label>
                    <input type="date" id="fechaEmision" name="fechaEmision">
                </div>
                <div class="form-group">
                    <label for="fechaExpiracion">Fecha de Expiración</label>
                    <input type="date" id="fechaExpiracion" name="fechaExpiracion">
                </div>
                <div class="form-group">
                    <label for="tipoVisa">Tipo de Visa</label>
                    <select id="tipoVisa" name="tipoVisa">
                        <option value="definitivo">Definitivo</option>
                        <option value="democratica">Democrática</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="turista">Turista</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nroID">Nro. ID</label>
                    <input type="text" id="nroID" name="nroID">
                </div>
                <div class="form-group">
                    <label for="nroDocumento">Nro. De Documento</label>
                    <input type="text" id="nroDocumento" name="nroDocumento">
                </div>
                <div class="form-group">
                    <label for="consejosViaje">¿Desea consejos para su viaje?</label>
                    <input type="checkbox" id="consejosViaje" name="consejosViaje">
                </div>
                <button type="submit" id="submitButtonExtra">Enviar</button>
            </form>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo",window.scrollY>0)
        });

        function toggleForm(){
            var nacionalidad =document.getElementById("nacionalidad").value;
            var extraForm = document.getElementById("extraForm");
            var submitButton =document.getElementById("submitButton");
            if (nacionalidad == "extranjera"){
                extraForm.style.display = "block";
                submitButton.style.display = "none";
            } else {
                extraForm.style.display = "none";
                submitButton.style.display = "block";
            }
        }
    </script>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
