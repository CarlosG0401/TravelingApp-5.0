<?php
session_start();
include 'php/conexion_be.php';
require('fpdf/fpdf.php'); // Asegúrate de que la ruta sea correcta

// Captura la salida para evitar problemas con FPDF
ob_start();

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
$query_user = "SELECT id FROM users WHERE username='$email'"; // Cambiado a email
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

    // Obtener datos del vuelo y de precios relacionados con el usuario
    $query_vuelo = "
        SELECT a.nombre AS aerolinea, v.origen, v.destino, v.fecha AS fecha_salida, p.precio_ida AS precio
        FROM aerolineas a
        INNER JOIN viajes v ON a.viaje_id = v.id
        INNER JOIN precios p ON a.id = p.aerolinea_id
        WHERE a.id = 1"; // Cambia por la lógica para obtener el vuelo seleccionado

    $result_vuelo = mysqli_query($conexion, $query_vuelo);
    $vuelo = mysqli_fetch_assoc($result_vuelo);

    if (!$vuelo) {
        echo '
            <script>
                alert("No se encontraron detalles del vuelo.");
                window.location = "pago.php";
            </script>
        ';
        die();
    }

    // Calcular el precio con IVA (supongamos que el IVA es del 19%)
    $precio_base = $vuelo['precio']; // Precio base del vuelo
    $iva = $precio_base * 0.19; // Calcula el IVA
    $total = $precio_base + $iva; // Precio total con IVA

    // Crear el PDF con los detalles del pago y vuelo
    $pdf = new FPDF();
    $pdf->AddPage();
    // Agregar logo
    $pdf->Image('assets/images/imagen-foto-removebg-preview.png', 10, 10, 30); // Ajusta la ruta y el tamaño del logo
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Factura de Pago', 0, 1, 'C');
    $pdf->Ln(20);

    // Información de la empresa
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 10, 'TravelingWeb', 0, 0);
    $pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
    $pdf->Cell(100, 10, 'Direccion: Av. Valle Del Norte 123, Huechuraba, Santiago, Chile', 0, 0);
    $pdf->Cell(0, 10, 'Numero de Factura: 0001', 0, 1, 'R');
    $pdf->Ln(10);

    // Detalles del cliente
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles del Cliente', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nombre: ' . $nombre_titular, 0, 1);
    $pdf->Ln(10);

    // Detalles del vuelo
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles del Vuelo', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Origen:', 1);
    $pdf->Cell(0, 10, $vuelo['origen'], 1, 1);
    $pdf->Cell(40, 10, 'Destino:', 1);
    $pdf->Cell(0, 10, $vuelo['destino'], 1, 1);
    $pdf->Cell(40, 10, 'Fecha de Salida:', 1);
    $pdf->Cell(0, 10, $vuelo['fecha_salida'], 1, 1);
    $pdf->Cell(40, 10, 'Aerolinea:', 1);
    $pdf->Cell(0, 10, $vuelo['aerolinea'], 1, 1);
    $pdf->Ln(10);

    // Precio
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles del Pago', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Precio Base:', 1);
    $pdf->Cell(0, 10, '$' . number_format($precio_base, 2), 1, 1);
    $pdf->Cell(40, 10, 'IVA (19%):', 1);
    $pdf->Cell(0, 10, '$' . number_format($iva, 2), 1, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Total:', 1);
    $pdf->Cell(0, 10, '$' . number_format($total, 2), 1, 1);

    // Limpiar el buffer de salida antes de generar el PDF
    ob_end_clean();

    // Descargar el PDF
    $pdf->Output('D', 'boleta_pago.pdf');

} else {
    echo '
        <script>
            alert("Error al procesar el pago.");
            window.location = "pago.php";
        </script>
    ';
}
?>