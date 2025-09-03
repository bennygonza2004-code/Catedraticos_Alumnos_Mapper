<?php
require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';

class AlumnoController {
    private $servicio; // AlumnoServiceInterface

    public function __construct(AlumnoServiceInterface $servicio) {
        $this->servicio = $servicio;
    }

    public function manejar($method, $data) {
        switch ($method) {
            case 'GET':    return $this->servicio->obtenerAlumnos();
            case 'POST':   return $this->servicio->agregarAlumnos($data ?? []);
            case 'PUT':    return $this->servicio->actualizarAlumno($data ?? []);
            case 'DELETE': return isset($data['id'])
                                ? $this->servicio->eliminarAlumno((int)$data['id'])
                                : ["success" => false, "errores" => ["ID no proporcionado"]];
            default:       return ["error" => "Método no soportado"];
        }
    }
}
