<?php
include 'php/conexion_be.php';

// Inicializar variables
$origen = isset($_POST['origen']) ? $_POST['origen'] : '';
$destino = isset($_POST['destino']) ? $_POST['destino'] : '';
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

// Verificar que todos los campos están completos
if (empty($origen) || empty($destino) || empty($fecha) || empty($cantidad)) {
    echo "Todos los campos son requeridos.";
    exit;
}

// Consulta para obtener los viajes disponibles
$query = "
    SELECT v.*, p.precio_ida, p.precio_ida_vuelta 
    FROM viajes v
    JOIN precios p ON v.precio_id = p.id
    WHERE v.origen = '$origen' AND v.destino = '$destino' AND v.fecha = '$fecha' AND v.disponible >= $cantidad
";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="assets/styles/buscar_viajes_styles.css">
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

    <div class="search-container">
        <h2>Resultados de Búsqueda</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='results-table'>";
            echo "<tr><th>Origen</th><th>Destino</th><th>Fecha</th><th>Disponible</th><th>Precio Ida</th><th>Precio Ida y Vuelta</th><th>Acción</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['origen'] . "</td>";
                echo "<td>" . $row['destino'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['disponible'] . "</td>";
                echo "<td>$" . $row['precio_ida'] . "</td>";
                echo "<td>$" . $row['precio_ida_vuelta'] . "</td>";
                echo "<td><a href='reservar.php?id=" . $row['id'] . "&cantidad=" . $cantidad . "'>Reservar</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron viajes disponibles.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>


    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>


