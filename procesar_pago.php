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

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Informacion Sobre Nueva York', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, 'Nueva York, la ciudad que nunca duerme, es conocida por su vibrante vida cultural, sus iconicos rascacielos y sus famosos barrios. Desde la Estatua de la Libertad hasta Times Square, hay algo para todos en esta metropoli global.');
    $pdf->Ln(10);

    // Ajusta las coordenadas de las imágenes
    $image1_x = 10; // Coordenada x para la primera imagen
    $image1_y = $pdf->GetY(); // Coordenada y para la primera imagen, usa la posición actual de Y

    $image2_x = 110; // Coordenada x para la segunda imagen
    $image2_y = $image1_y; // Coordenada y para la segunda imagen, debe estar en la misma fila que la primera

    $pdf->Image('assets/images/empire-state-mirador-161004120416001.jpeg', $image1_x, $image1_y, 90); // Ajusta la ruta y el tamaño
    $pdf->Image('assets/images/new-york-city-555749235-59d5839a685fbe0011fda06b.jpg', $image2_x, $image2_y, 90); // Ajusta la ruta y el tamaño

    // Establece la fuente para el enlace
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(0, 0, 255); // Color azul para el enlace

    // Mueve la posición actual en la página
    $pdf->Ln(70); // Espacio vertical desde la posición actual para asegurar que el enlace esté separado de las imágenes

    // Agrega el texto y enlace en la posición deseada
    $pdf->Cell(0, 10, 'Ubicacion del Aeropuerto en Google Maps:', 0, 1); // Agrega el texto
    $pdf->Cell(0, 10, 'Haz clic aqui para ver la ubicacion', 0, 1, 'L', false, 'https://maps.app.goo.gl/szv2ZYWXSkoEHJjd9'); // Enlace a Google Maps
    $pdf->Image('assets/images/image.png', 10, $pdf->GetY(), 180);

    // Restablecer color del texto
    $pdf->SetTextColor(0, 0, 0);

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Informacion Adicional sobre Nueva York', 0, 1, 'C');
    $pdf->Ln(10);


    // Información de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, 'Casa de cambio mas cercana', 1);
    $pdf->Cell(90, 10, 'Change Exchange', 1, 1); // Nombre de la casa de cambio

    $pdf->Cell(90, 10, 'Distancia al aeropuerto', 1);
    $pdf->Cell(90, 10, '500 m', 1, 1); // Distancia estimada
    $pdf->Ln(10);

    $pdf->Cell(60, 10, 'Hoteles mas cercanos', 1);
    $pdf->Cell(40, 10, 'Ubicacion', 1);
    $pdf->Cell(40, 10, 'Precio por noche', 1);
    $pdf->Cell(30, 10, 'Camas', 1, 1);

    $pdf->Cell(60, 10, 'Hotel Central', 1);
    $pdf->Cell(40, 10, 'Standard Location', 1);
    $pdf->Cell(40, 10, '$150', 1);
    $pdf->Cell(30, 10, '2', 1, 1);

    $pdf->Cell(60, 10, 'Hotel Plaza', 1);
    $pdf->Cell(40, 10, 'Standard Location', 1);
    $pdf->Cell(40, 10, '$200', 1);
    $pdf->Cell(30, 10, '3', 1, 1);
    $pdf->Ln(10);

    $pdf->Cell(90, 10, 'Precio estimado en metro', 1);
    $pdf->Cell(90, 10, '$2.75', 1, 1); // Precio estimado del trayecto en metro
    $pdf->Ln(10);

    $pdf->Cell(90, 10, 'Precio estimado en taxi', 1);
    $pdf->Cell(90, 10, '$50', 1, 1); // Precio estimado del trayecto en taxi
    // Limpiar el buffer de salida antes de generar el PDF
    ob_end_clean();

    // Descargar el PDF
    //$pdf->Output('D', 'boleta_pago.pdf');

    $archivo_pdf = 'boleta_pago.pdf';
    $pdf->Output('F', $archivo_pdf);

    // Redirigir al usuario a enviar_pdf.php
    header('Location: enviar_pdf.php');
    exit();

} else {
    echo '
        <script>
            alert("Error al procesar el pago.");
            window.location = "pago.php";
        </script>
    ';
}
?>