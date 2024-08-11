<?php
include 'php/conexion_be.php';

$id = $_GET['id'];

// Consulta para obtener las aerolíneas disponibles sin duplicados
$query = "
    SELECT a.tipo_vuelo, a.nombre AS Aerolinea, a.hora_salida, a.hora_llegada, a.id AS aerolinea_id
    FROM aerolineas a
    LEFT JOIN precios p ON a.id = p.aerolinea_id
    WHERE a.viaje_id = $id
    GROUP BY a.tipo_vuelo, a.nombre, a.hora_salida, a.hora_llegada
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
    <title>Reservar Vuelo</title>
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
        <h2>Aerolíneas Disponibles</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='results-table'>";
            echo "<tr><th>Tipo de Vuelo</th><th>Aerolínea</th><th>Hora de Salida</th><th>Hora de Llegada</th><th>Acción</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['tipo_vuelo'] . "</td>";
                echo "<td>" . $row['Aerolinea'] . "</td>";
                echo "<td>" . $row['hora_salida'] . "</td>";
                echo "<td>" . $row['hora_llegada'] . "</td>";
                
                // Condición para verificar si 'aerolinea_id' está definido
                if (isset($row['aerolinea_id'])) {
                    echo "<td><a href='precios.php?id=" . $row['aerolinea_id'] . "' class='btn'>Ver Precios</a></td>";
                } else {
                    echo "<td>No hay precios disponibles</td>";
                }
                
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron aerolíneas disponibles.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

