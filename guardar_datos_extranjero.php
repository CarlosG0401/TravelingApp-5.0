<?php
session_start();
require 'php/conexion_be.php'; // Incluimos la conexión a la base de datos

function validarDatos($documento, $fechaExpiracion, $nroID, $nroDocumento, $tipoVisa, $fechaExpiracionVisa) {
    $errores = [];
    $fechaActual = date("Y-m-d");

    // Validar fecha de expiración del documento
    if ($fechaExpiracion < $fechaActual) {
        $errores[] = "El $documento está expirado.";
    }

    // Validar número de ID y número de documento
    if (strlen($nroID) != 9) {
        $errores[] = "El Nro. ID debe tener al menos 9 caracteres.";
    }
    if (strlen($nroDocumento) != 9) {
        $errores[] = "El Nro. de Documento debe tener al menos 9 caracteres.";
    }

    // Validar otras visas para extranjeros
    if (in_array($tipoVisa, ['definitivo', 'democratica', 'estudiante', 'turista']) && $fechaExpiracionVisa < $fechaActual) {
        $errores[] = "La Visa $tipoVisa está expirada.";
    }

    return $errores;
}

// Datos personales
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$edad = $_SESSION['edad'];
$email = $_SESSION['email'];
$sexo = $_SESSION['sexo'];
$fechaNacimiento = $_SESSION['fechaNacimiento'];
$nacionalidad = $_SESSION['nacionalidad'];

// Datos de documentación
$extraNacionalidad = $_POST['extraNacionalidad'];
$documento = $_POST['documento'];
$fechaEmision = $_POST['fechaEmision'];
$fechaExpiracion = $_POST['fechaExpiracion'];
$tipoVisa = $_POST['tipoVisa'];
$nroID = $_POST['nroID'];
$nroDocumento = $_POST['nroDocumento'];
$consejosViaje = isset($_POST['consejosViaje']) ? 1 : 0;

$fechaEmisionVisa = isset($_POST['fechaEmisionVisa']) ? $_POST['fechaEmisionVisa'] : null;
$fechaExpiracionVisa = isset($_POST['fechaExpiracionVisa']) ? $_POST['fechaExpiracionVisa'] : null;

$errores = validarDatos($documento, $fechaExpiracion, $nroID, $nroDocumento, $tipoVisa, $fechaExpiracionVisa);

if (empty($errores)) {
    // Insertar en datos_personales
    $stmt = $conexion->prepare("INSERT INTO datos_personales (nombre, apellido, edad, email, sexo, fecha_nacimiento, nacionalidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $nombre, $apellido, $edad, $email, $sexo, $fechaNacimiento, $nacionalidad);

    if ($stmt->execute()) {
        // Obtener el ID del registro insertado
        $datosPersonalesId = $stmt->insert_id;

        // Insertar en documentacion
        $stmt = $conexion->prepare("INSERT INTO documentacion (datos_personales_id, tipo_documento, fecha_emision, fecha_expiracion, tipo_visa, nro_id, nro_documento, consejos_viaje, fecha_emision_visa, fecha_expiracion_visa)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $datosPersonalesId, $documento, $fechaEmision, $fechaExpiracion, $tipoVisa, $nroID, $nroDocumento, $consejosViaje, $fechaEmisionVisa, $fechaExpiracionVisa);

        if ($stmt->execute()) {
            echo "Datos guardados exitosamente.";

            // Mostrar recomendaciones específicas para cada país
            if ($extraNacionalidad == 'venezuela') {
                echo "<p>Recomendaciones para ciudadanos venezolanos:</p>";
                echo "<ul>";
                echo "<li>Para renovar el RUT venezolano, sigue los siguientes pasos: <a href='https://www.example.com/renovar-rut-venezolano' target='_blank'>Renovar RUT venezolano</a></li>";
                echo "<li>Para renovar el pasaporte venezolano, sigue los siguientes pasos: <a href='https://www.example.com/renovar-pasaporte-venezolano' target='_blank'>Renovar pasaporte venezolano</a></li>";
                echo "<li>Para Nro ID y Nro Documento, escribe nuevamente dígitos válidos.</li>";
                echo "</ul>";
            } elseif ($extraNacionalidad == 'colombia') {
                echo "<p>Recomendaciones para ciudadanos colombianos:</p>";
                echo "<ul>";
                echo "<li>Para renovar el RUT colombiano, sigue los siguientes pasos: <a href='https://www.example.com/renovar-rut-colombiano' target='_blank'>Renovar RUT colombiano</a></li>";
                echo "<li>Para renovar el pasaporte colombiano, sigue los siguientes pasos: <a href='https://www.example.com/renovar-pasaporte-colombiano' target='_blank'>Renovar pasaporte colombiano</a></li>";
                echo "<li>Para Nro ID y Nro Documento, escribe nuevamente dígitos válidos.</li>";
                echo "</ul>";
            } elseif ($extraNacionalidad == 'paraguay') {
                echo "<p>Recomendaciones para ciudadanos paraguayos:</p>";
                echo "<ul>";
                echo "<li>Para renovar el RUT paraguayo, sigue los siguientes pasos: <a href='https://www.example.com/renovar-rut-paraguayo' target='_blank'>Renovar RUT paraguayo</a></li>";
                echo "<li>Para renovar el pasaporte paraguayo, sigue los siguientes pasos: <a href='https://www.example.com/renovar-pasaporte-paraguayo' target='_blank'>Renovar pasaporte paraguayo</a></li>";
                echo "<li>Para Nro ID y Nro Documento, escribe nuevamente dígitos válidos.</li>";
                echo "</ul>";
            }

        } else {
            echo "Error al guardar la documentación: " . $stmt->error;
        }
    } else {
        echo "Error al guardar los datos personales: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errores en la Documentación</title>
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
        <div class="error-container">
            <h2>Errores en la Documentación</h2>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <style>
        .error-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            max-width: 500px;
            text-align: center;
        }
        .error-container h2 {
            color: #ff0000;
        }
        .error-container ul {
            list-style-type: none;
            padding: 0;
        }
        .error-container li {
            margin: 10px 0;
        }
        .btn-azul {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-azul:hover {
            background-color: #0056b3;
        }
        .recomendaciones {
            margin-top: 20px;
        }
        .recomendaciones h3 {
            color: #0000ff;
        }
        .recomendaciones ul {
            list-style-type: none;
            padding: 0;
        }
        .recomendaciones li {
            margin: 10px 0;
        }
        .recomendaciones a {
            color: #007bff;
            text-decoration: none;
        }
        .recomendaciones a:hover {
            text-decoration: underline;
        }
    </style>
     <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        });
    </script>
</body>
</html>
<?php
}
?>

