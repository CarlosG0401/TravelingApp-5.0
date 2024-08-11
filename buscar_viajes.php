<?php
include 'php/conexion_be.php';

// Inicializar variables
$origen = isset($_POST['origen']) ? $_POST['origen'] : '';
$destino = isset($_POST['destino']) ? $_POST['destino'] : '';
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

// Verificar que todos los campos están completos
if (empty($origen) || empty($destino) || empty($fecha_inicio) || empty($fecha_fin)) {
    echo "Todos los campos son requeridos.";
    exit;
}

// Consulta para obtener los viajes disponibles en el rango de fechas
$query = "
    SELECT DISTINCT v.id, v.origen, v.destino, v.fecha, v.dias
    FROM viajes v
    WHERE v.origen = '$origen' 
      AND v.destino = '$destino' 
      AND v.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
";

// Ejecutar la consulta
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
            echo "<tr><th>Origen</th><th>Destino</th><th>Fecha</th><th>Acción</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['origen'] . "</td>";
                echo "<td>" . $row['destino'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td><a href='reservar.php?id=" . $row['id'] . "&dias=" . $row['dias'] . "' class='btn'>Opciones</a></td>";
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
