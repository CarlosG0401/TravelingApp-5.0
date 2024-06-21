<?php
session_start();
require 'php/conexion_be.php'; // Incluimos la conexión a la base de datos

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

$fechaEmisionVisa = isset($_POST['fechaEmisionVisa']) ? $_POST['fechaEmisionVisa'] : null;
$fechaExpiracionVisa = isset($_POST['fechaExpiracionVisa']) ? $_POST['fechaExpiracionVisa'] : null;

// Datos de Visa Waiver
$fechaEmisionVW = isset($_POST['fechaEmisionVW']) ? $_POST['fechaEmisionVW'] : null;
$fechaExpiracionVW = isset($_POST['fechaExpiracionVW']) ? $_POST['fechaExpiracionVW'] : null;

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
        echo "Datos guardados exitosamente.";
    } else {
        echo "Error al guardar la documentación: " . $stmt->error;
    }
} else {
    echo "Error al guardar los datos personales: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
