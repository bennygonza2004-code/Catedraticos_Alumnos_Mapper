<?php
function getConexion() {
    $conexion = new mysqli("localhost", "root", "", "alumnos_docentes");
    if ($conexion->connect_error) {
        http_response_code(500);
        die(json_encode(["error" => "Conexión fallida: " . $conexion->connect_error]));
    }
    // Asegura charset correcto
    $conexion->set_charset("utf8mb4");
    return $conexion;
}
