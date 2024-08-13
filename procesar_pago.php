<?php
session_start();
include 'php/conexion_be.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    echo '
        <script>
            alert("Por favor, debes iniciar sesión.");
            window.location = "index.php";
        </script>
    ';
    die();
}

// Captura los datos del formulario de pago
$nombre_titular = $_POST['nombreTarjeta'] ?? null;
$numero_tarjeta = $_POST['numeroTarjeta'] ?? null;
$fecha_expiracion = $_POST['fechaExpiracionTarjeta'] ?? null;
$cvv = $_POST['cvv'] ?? null;

// Verifica que todos los campos hayan sido enviados
if (empty($nombre_titular) || empty($numero_tarjeta) || empty($fecha_expiracion) || empty($cvv)) {
    echo '
        <script>
            alert("Todos los campos son obligatorios.");
            window.location = "pago.php";
        </script>
    ';
    die();
}

// Obtén el ID del usuario desde la sesión
$email = $_SESSION['user'];
$query_user = "SELECT id FROM users WHERE username='$email'";
$result_user = mysqli_query($conexion, $query_user);

if (!$result_user) {
    echo '
        <script>
            alert("Error en la consulta SQL: ' . mysqli_error($conexion) . '");
            window.location = "pago.php";
        </script>
    ';
    die();
}

$usuario = mysqli_fetch_assoc($result_user);
$id_usuario = $usuario['id'] ?? null;

if (!$id_usuario) {
    echo '
        <script>
            alert("No se encontró el usuario en la base de datos.");
            window.location = "pago.php";
        </script>
    ';
    die();
}

// Inserta los datos del pago en la tabla pagos
$query_pago = "INSERT INTO pagos(nombre_titular, numero_tarjeta, fecha_expiracion, cvv, id_usuario) 
               VALUES ('$nombre_titular', '$numero_tarjeta', '$fecha_expiracion', '$cvv', '$id_usuario')";

$ejecutar = mysqli_query($conexion, $query_pago);

if ($ejecutar) {
    echo '
        <script>
            alert("Pago realizado con éxito.");
            window.location = "index.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Hubo un error al procesar el pago: ' . mysqli_error($conexion) . '");
            window.location = "pago.php";
        </script>
    ';
}

mysqli_close($conexion);
?>
