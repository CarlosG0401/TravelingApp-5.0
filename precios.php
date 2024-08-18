<?php

session_start();

if (!isset($_SESSION['user'])) {
    // Si no está logueado, redirige a una página con un mensaje o un pop-up
    echo "<script>
        alert('Por favor, inicie sesión para continuar.');
        window.location.href='index.php';
    </script>";
    exit;
}

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
    <style>
        .check-container {
            display: flex;
            align-items: center;
        }

        .check-container input[type="checkbox"] {
            margin: 0 5px;
        }
    </style>
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
            <?php
            if (isset($_SESSION['user'])) {
                // Mostrar el nombre de usuario y la opción de cerrar sesión si el usuario está autenticado
                echo '<span class="header-user" style="color: white;">Bienvenido, ' . $_SESSION['user'] . '</span>';
                echo '<a href="php/cerrar_session.php">Cerrar sesión</a>';
            } else {
                // Mostrar el botón de Login si no hay sesión iniciada
                echo '<button class="btnLogin-popup">Login</button>';
            }
            ?>
        </nav>
    </header>

    <div class="search-container">
        <h2>Precios Disponibles</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='results-table'>";
            echo "<tr><th>Precio Ida</th><th>Precio Ida y Vuelta</th><th>Detalles</th><th>Operación</th><th>Ida</th><th>Ida y Vuelta</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $precioIda = $row['precio_ida'];
                $precioIdaVuelta = $row['precio_ida_vuelta'];
                $id = uniqid(); // Genera un identificador único para cada fila
                echo "<tr>";
                echo "<td>$" . $precioIda . "</td>";
                echo "<td>$" . $precioIdaVuelta . "</td>";
                echo "<td><a href='detalles_precio.php?precio_ida=$precioIda&precio_ida_vuelta=$precioIdaVuelta' class='btn'>Ver Detalles</a></td>";
                echo "<td><a href='formulario.php?precio_ida=$precioIda&precio_ida_vuelta=$precioIdaVuelta' class='btn'>Rellenar</a></td>";
                echo "<td><div class='check-container'><input type='checkbox' id='ida_$id' name='check_$id' class='check-id' /></div></td>";
                echo "<td><div class='check-container'><input type='checkbox' id='ida_vuelta_$id' name='check_$id' class='check-vuelta' /></div></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron precios disponibles.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>

    <script>
        // Función para desmarcar todas las casillas en todas las filas
        function desmarcarTodasLasCasillas() {
            document.querySelectorAll('.results-table input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }

        // Añadir el evento change a todas las casillas de verificación
        document.querySelectorAll('.check-container input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Desmarcar todas las casillas en todas las filas
                    desmarcarTodasLasCasillas();

                    // Marcar solo la casilla seleccionada
                    this.checked = true;
                }
            });
        });
    </script>

    <script src="assets/script/scripts.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>