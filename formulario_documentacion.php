<?php
    // Recibimos los datos personales
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellido'] = $_POST['apellido'];
        $_SESSION['edad'] = $_POST['edad'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['sexo'] = $_POST['sexo'];
        $_SESSION['fechaNacimiento'] = $_POST['fechaNacimiento'];
        $_SESSION['nacionalidad'] = $_POST['nacionalidad'];
    } else {
        // Redirigir al formulario inicial si no hay datos
        header("Location: formulario.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Documentación</title>
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

    <section class="zona2">
        <?php if ($_SESSION['nacionalidad'] == 'chilena'): ?>
            <div class="form-container">
                <h2>Documentación Chilena</h2>
                <form action="guardar_datos.php" method="post">
                    <div class="form-group">
                        <label for="documentoChilena">Documento</label>
                        <select id="documentoChilena" name="documento" required>
                            <option value="rut">RUT</option>
                            <option value="pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaEmisionChilena">Fecha de Emisión</label>
                        <input type="date" id="fechaEmisionChilena" name="fechaEmision" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaExpiracionChilena">Fecha de Expiración</label>
                        <input type="date" id="fechaExpiracionChilena" name="fechaExpiracion" required>
                    </div>
                    <div class="form-group">
                        <label for="tipoVisaChilena">Tipo de Visa</label>
                        <select id="tipoVisaChilena" name="tipoVisa" required onchange="toggleVisaWaiverFields()">
                            <option value="N/A">N/A</option>
                            <option value="visa_waiver">Visa Waiver</option>
                        </select>
                    </div>
                    <div class="form-group" id="visaWaiverFields" style="display: none;">
                        <label for="fechaEmisionVW">Fecha de Emisión Visa Waiver</label>
                        <input type="date" id="fechaEmisionVW" name="fechaEmisionVW">
                        <label for="fechaExpiracionVW">Fecha de Expiración Visa Waiver</label>
                        <input type="date" id="fechaExpiracionVW" name="fechaExpiracionVW">
                    </div>
                    <div class="form-group">
                        <label for="nroIDChilena">Nro. ID</label>
                        <input type="text" id="nroIDChilena" name="nroID" required>
                    </div>
                    <div class="form-group">
                        <label for="nroDocumentoChilena">Nro. De Documento</label>
                        <input type="text" id="nroDocumentoChilena" name="nroDocumento" required>
                    </div>
                    <div class="form-group">
                        <label for="consejosViajeChilena">¿Desea consejos para su viaje?</label>
                        <input type="checkbox" id="consejosViajeChilena" name="consejosViaje">
                    </div>
                    <button type="submit" class="btn-azul">Enviar</button>
                </form>
            </div>
        <?php elseif ($_SESSION['nacionalidad'] == 'extranjera'): ?>
            <div class="form-container">
                <h2>Documentación Extranjera</h2>
                <form action="guardar_datos_extrajero.php" method="post">
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
                        <select id="documento" name="documento" required>
                            <option value="rut">RUT</option>
                            <option value="pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaEmision">Fecha de Emisión</label>
                        <input type="date" id="fechaEmision" name="fechaEmision" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaExpiracion">Fecha de Expiración</label>
                        <input type="date" id="fechaExpiracion" name="fechaExpiracion" required>
                    </div>
                    <div class="form-group">
                        <label for="tipoVisa">Tipo de Visa</label>
                        <select id="tipoVisa" name="tipoVisa" required>
                            <option value="definitivo">Definitivo</option>
                            <option value="democratica">Democrática</option>
                            <option value="estudiante">Estudiante</option>
                            <option value="turista">Turista</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaEmisionVisa">Fecha de Emisión Visa</label>
                        <input type="date" id="fechaEmisionVisa" name="fechaEmisionVisa" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaExpiracionVisa">Fecha de Expiración Visa</label>
                        <input type="date" id="fechaExpiracionVisa" name="fechaExpiracionVisa" required>
                    </div>
                    <div class="form-group">
                        <label for="nroID">Nro. ID</label>
                        <input type="text" id="nroID" name="nroID" required>
                    </div>
                    <div class="form-group">
                        <label for="nroDocumento">Nro. De Documento</label>
                        <input type="text" id="nroDocumento" name="nroDocumento" required>
                    </div>
                    <div class="form-group">
                        <label for="consejosViaje">¿Desea consejos para su viaje?</label>
                        <input type="checkbox" id="consejosViaje" name="consejosViaje">
                    </div>
                    <button type="submit" class="btn-azul">Enviar</button>
                </form>
            </div>
        <?php endif; ?>
    </section>
    <script type="text/javascript">
        function toggleVisaWaiverFields() {
            var tipoVisa = document.getElementById('tipoVisaChilena').value;
            var visaWaiverFields = document.getElementById('visaWaiverFields');
            if (tipoVisa === 'visa_waiver') {
                visaWaiverFields.style.display = 'block';
            } else {
                visaWaiverFields.style.display = 'none';
            }
        }

        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        });
    </script>
</body>
</html>