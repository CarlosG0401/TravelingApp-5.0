<?php
session_start();
require 'php/conexion_be.php'; // Incluimos la conexión a la base de datos

function validarDatos($documento, $fechaExpiracion, $nroID, $nroDocumento, $tipoVisa, $fechaExpiracionVisa, $fechaExpiracionVW, $destino, $nacionalidad, $fechaEmisionVW) {
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

    // Validar visa waiver para chilenos
    if ($tipoVisa == 'visa_waiver' && $fechaExpiracionVW < $fechaActual) {
        $errores[] = "La Visa Waiver está expirada.";
    }

    // Validar otras visas para extranjeros
    if (in_array($tipoVisa, ['definitivo', 'democratica', 'estudiante', 'turista']) && $fechaExpiracionVisa < $fechaActual) {
        $errores[] = "La Visa $tipoVisa está expirada.";
    }

    // Validación específica para destino Nueva York
    if ($destino == 'New York' && $nacionalidad == 'chilena') {
        // Si no se ingresó visa waiver y es necesario
        if ($tipoVisa != 'visa_waiver' || !$fechaEmisionVW || !$fechaExpiracionVW || $fechaExpiracionVW < $fechaActual) {
            $errores[] = "Para viajar a New York, los ciudadanos chilenos deben tener una Visa Waiver válida. Por favor, obtenga o renueve su Visa Waiver. <a href='https://esta.cbp.dhs.gov/' target='_blank'>Obtener o renovar Visa Waiver</a>";
        }
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
$documento = $_POST['documento'];
$fechaEmision = $_POST['fechaEmision'];
$fechaExpiracion = $_POST['fechaExpiracion'];
$tipoVisa = $_POST['tipoVisa'];
$nroID = $_POST['nroID'];
$nroDocumento = $_POST['nroDocumento'];
$consejosViaje = isset($_POST['consejosViaje']) ? 1 : 0;
//$destino = $_SESSION['destino'];

$fechaEmisionVisa = isset($_POST['fechaEmisionVisa']) ? $_POST['fechaEmisionVisa'] : null;
$fechaExpiracionVisa = isset($_POST['fechaExpiracionVisa']) ? $_POST['fechaExpiracionVisa'] : null;

// Datos de Visa Waiver
$fechaEmisionVW = isset($_POST['fechaEmisionVW']) ? $_POST['fechaEmisionVW'] : null;
$fechaExpiracionVW = isset($_POST['fechaExpiracionVW']) ? $_POST['fechaExpiracionVW'] : null;

// Obtener el destino del viaje
$sql = "SELECT v.destino 
        FROM viajes v
        JOIN documentacion d ON v.id = d.datos_personales_id
        JOIN datos_personales dp ON dp.id = d.datos_personales_id
        WHERE dp.nombre = ? AND dp.apellido = ? AND dp.email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre, $apellido, $email);
$stmt->execute();
$stmt->bind_result($destinoDb);
$stmt->fetch();
$stmt->close();

$errores = validarDatos($documento, $fechaExpiracion, $nroID, $nroDocumento, $tipoVisa, $fechaExpiracionVisa, $fechaExpiracionVW, $destinoDb, $nacionalidad, $fechaEmisionVW);

if (empty($errores)) {
    // Insertar en datos_personales
    $stmt = $conexion->prepare("INSERT INTO datos_personales (nombre, apellido, edad, email, sexo, fecha_nacimiento, nacionalidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $nombre, $apellido, $edad, $email, $sexo, $fechaNacimiento, $nacionalidad);

    if ($stmt->execute()) {
        // Obtener el ID del registro insertado
        $datosPersonalesId = $stmt->insert_id;

        // Insertar en documentacion
        $stmt = $conexion->prepare("INSERT INTO documentacion (datos_personales_id, tipo_documento, fecha_emision, fecha_expiracion, tipo_visa, nro_id, nro_documento, consejos_viaje, fecha_emision_vw, fecha_expiracion_vw, fecha_emision_visa, fecha_expiracion_visa)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssssss", $datosPersonalesId, $documento, $fechaEmision, $fechaExpiracion, $tipoVisa, $nroID, $nroDocumento, $consejosViaje, $fechaEmisionVW, $fechaExpiracionVW, $fechaEmisionVisa, $fechaExpiracionVisa);

        if ($stmt->execute()) {
            header("Location: pago.php");
            exit();
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
            <?php
            if (isset($_SESSION['user'])) {
                // Muestra el nombre de usuario y la opción de cerrar sesión si está iniciada
                echo '<span class="header-user" style="color: white;">Bienvenido, ' . $_SESSION['user'] . '</span>';
                echo '<a href="php/cerrar_session.php">Cerrar sesión</a>';
            } else {
                echo '<button class="btnLogin-popup">Login</button>';
            }
            ?>
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
            <div class="recomendaciones">
                <h3>Recomendaciones</h3>
                <ul>
                    <li>Para renovar el RUT chileno, sigue los siguientes pasos: <a href="https://www.chileatiende.gob.cl/fichas/2937-renovacion-de-cedula-de-identidad-para-chilenos" target="_blank">Renovar RUT chileno</a></li>
                    <li>Para renovar el pasaporte chileno, sigue los siguientes pasos: <a href="https://www.chileatiende.gob.cl/fichas/2912-renovacion-de-pasaporte" target="_blank">Renovar pasaporte chileno</a></li>
                    <li>Para Nro ID y Nro Documento, escribe nuevamente dígitos válidos.</li>
                </ul>
            </div>
            <button onclick="window.location.href='formulario_documentacion.php'" class="btn-azul">Volver</button>
        </div>
    </section>
    <style>
        .error-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            max-width: 800px;
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
            padding: 20px 70px;
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