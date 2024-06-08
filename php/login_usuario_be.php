<?php
    session_start();

    include 'conexion_be.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = hash('sha512', $password);

    $validar_login = mysqli_query($conexion, "SELECT * FROM users WHERE email='$email' and password='$password'");

    if(mysqli_num_rows($validar_login) > 0 ){
        $_SESSION['user'] = $email;
        header("location: ../bienvenida.php");
        exit;
    }else{
        echo '
            <script>
                alert("Usuario no existe, por favor verifique los datos introducidos");
                window.location = "../index.php";
            </script>
        ';
        exit;
    }