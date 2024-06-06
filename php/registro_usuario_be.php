<?php

    include 'conexion_be.php';

    $username= $_POST['username'];
    $email= $_POST['email'];
    $password= $_POST['password'];

    $query = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password')";

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Inténtalo de nuevo, usuario no almacenado");
                window.location = "../index.php";
            </script>
        ';
    }

    mysqli_close($conexion);