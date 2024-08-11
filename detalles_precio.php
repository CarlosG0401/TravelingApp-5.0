<?php
include 'php/conexion_be.php';

$precio_ida = isset($_GET['precio_ida']) ? $_GET['precio_ida'] : '';
$precio_ida_vuelta = isset($_GET['precio_ida_vuelta']) ? $_GET['precio_ida_vuelta'] : '';

// Consulta para obtener los detalles del precio
$query_precio = "
    SELECT id, precio_ida, precio_ida_vuelta
    FROM precios
    WHERE precio_ida = '$precio_ida' AND precio_ida_vuelta = '$precio_ida_vuelta'
";
$result_precio = mysqli_query($conexion, $query_precio);

if (!$result_precio) {
    die("Error en la consulta de precios: " . mysqli_error($conexion));
}

$precio = mysqli_fetch_assoc($result_precio);
$precio_id = $precio['id'];

// Consulta para obtener los detalles del vuelo
$query_detalle = "
    SELECT incluye, no_incluye
    FROM detalle_vuelos
    WHERE precio_id = $precio_id
";
$result_detalle = mysqli_query($conexion, $query_detalle);

if (!$result_detalle) {
    die("Error en la consulta de detalles: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Precio</title>
    <link rel="stylesheet" href="assets/styles/detalles_precio_style.css">
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

    <div class="details-container">
        <h2>Detalles del Precio</h2>
        <?php
        if (mysqli_num_rows($result_detalle) > 0) {
            $detalle = mysqli_fetch_assoc($result_detalle);
            echo "<p><strong>Precio Ida:</strong> $" . $precio['precio_ida'] . "</p>";
            echo "<p><strong>Precio Ida y Vuelta:</strong> $" . $precio['precio_ida_vuelta'] . "</p>";
            echo "<p><strong>Incluye:</strong></p>";
            echo "<ul class='include-list'>";
            $incluye_items = explode(', ', $detalle['incluye']);
            foreach ($incluye_items as $item) {
                echo "<li>" . htmlspecialchars($item) . "</li>";
            }
            echo "</ul>";
            echo "<p><strong>No Incluye:</strong></p>";
            echo "<ul class='include-list'>";
            $no_incluye_items = explode(', ', $detalle['no_incluye']);
            foreach ($no_incluye_items as $item) {
                echo "<li>" . htmlspecialchars($item) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron detalles para este precio.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>



