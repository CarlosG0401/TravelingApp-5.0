<?php
require 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

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

$archivo_pdf = $_GET['archivo'] ?? 'boleta_pago.pdf'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el envío del formulario
    $correo_destino = $_POST['correo'] ?? null;

    if (filter_var($correo_destino, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true); 

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'travelingweb9@gmail.com';
            $mail->Password = 'xkkziyjaeaatvnec';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('travelingweb9@gmail.com', 'TravelingWeb');
            $mail->addAddress($correo_destino);
            $mail->addAttachment($archivo_pdf); 

            $mail->isHTML(true);
            $mail->Subject = 'Copia de tu boleta de pago';
            $mail->Body = '
                <p>Estimado/a usuario/a,</p>
                <p>Adjunto a este correo encontrarás una copia de tu boleta de pago. Por favor, revisa el archivo adjunto para verificar los detalles.</p>
                <p>Si tienes alguna pregunta o necesitas más asistencia, no dudes en contactarnos.</p>
                <p>Saludos cordiales,</p>
                <p><strong>TravelingWeb</strong><br>
                Atención al Cliente<br>
                <a href="mailto:support@travelingweb.com">support@travelingweb.com</a><br>
                Teléfono: +56 (9) 555-1432</p>
                <p><em>Este es un mensaje automático generado por nuestro sistema. Por favor, no respondas a este correo.</em></p>
            ';

            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo 'El mensaje no pudo ser enviado. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Por favor ingresa un correo electrónico válido.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar PDF por Correo</title>
    <link rel="stylesheet" href="assets/styles/pago.css"> <!-- Incluir el mismo archivo CSS -->
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
            if(isset($_SESSION['user'])) {
                // Muestra el nombre de usuario y la opción de cerrar sesión si está iniciada
                echo '<span class="header-user" style="color: white;">Bienvenido, ' . $_SESSION['user'] . '</span>';
                echo '<a href="php/cerrar_session.php">Cerrar sesión</a>';
            }
            ?>
        </nav>
    </header>
    
    <section class="zona3">
        <div class="form-container">
            <h1>Enviar copia de tu boleta de pago por correo</h1>
            <form action="enviar_pdf.php?archivo=<?php echo urlencode($archivo_pdf); ?>" method="post" id="pdfForm">
                <div class="form-group">
                    <label for="correo">Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <button type="submit" class="btn-azul">Enviar Copia</button>
            </form>
        </div>
    </section>

    <!-- Pop-up para mensaje de éxito -->
    <div id="popupSuccess" class="popup">
        Mensaje enviado con éxito
    </div>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        });

        // Mostrar el pop-up si se envió el formulario
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_var($correo_destino, FILTER_VALIDATE_EMAIL)): ?>
            document.addEventListener("DOMContentLoaded", function() {
                var popup = document.getElementById('popupSuccess');
                popup.classList.add('show');
                setTimeout(function() {
                    popup.classList.remove('show');
                    popup.classList.add('hide');
                }, 3000); // El mensaje se oculta después de 3 segundos
            });
        <?php endif; ?>
    </script>
</body>
</html>
