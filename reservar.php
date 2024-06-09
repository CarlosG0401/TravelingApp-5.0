<?php
include 'php/conexion_be.php';

$id = $_GET['id'];
$cantidad = $_GET['cantidad'];

// Actualizar la disponibilidad
$query = "UPDATE viajes SET disponible = disponible - $cantidad WHERE id = $id";
if (mysqli_query($conexion, $query)) {
    echo "<p>Reserva realizada con éxito.</p>";
} else {
    echo "<p>Error al realizar la reserva.</p>";
}

mysqli_close($conexion);
