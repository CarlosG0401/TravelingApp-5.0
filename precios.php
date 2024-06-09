<?php
include 'php/conexion_be.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

// Consulta para obtener los precios disponibles
$query = "
    SELECT precio_ida, precio_ida_vuelta 
    FROM precios
    WHERE aerolinea_id = $id
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
    <title>Precios</title>
    <link rel="stylesheet" href="assets/styles/precios_styles.css">
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
        <h2>Precios Disponibles</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='results-table'>";
            echo "<tr><th>Precio Ida</th><th>Precio Ida y Vuelta</th><th>Operación</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>$" . $row['precio_ida'] . "</td>";
                echo "<td>$" . $row['precio_ida_vuelta'] . "</td>";
                echo "<td><button class='btn'>Rellenar</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron precios disponibles.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
