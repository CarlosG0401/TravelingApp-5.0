<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombreTarjeta = $_POST['nombreTarjeta'];
        $numeroTarjeta = $_POST['numeroTarjeta'];
        $fechaExpiracionTarjeta = $_POST['fechaExpiracionTarjeta'];
        $cvv = $_POST['cvv'];

        // Aquí agregarías la lógica para procesar el pago, por ejemplo, utilizando una API de un procesador de pagos

        // Suponiendo que el pago se realiza correctamente
        echo "Pago realizado correctamente.";
        // Redirigir a una página de confirmación, si es necesario
        // header("Location: confirmacion.php");
        // exit();
    } else {
        // Redirigir al formulario de pago si no se envió el formulario correctamente
        header("Location: pago.php");
        exit();
    }
?>
