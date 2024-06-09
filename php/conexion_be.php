<?php

    $conexion = mysqli_connect("localhost", "root", "", "travelingweb-3.0");

    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }