<?php
require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';

class CatedraticoController {
    private $servicio; // CatedraticoServiceInterface

    public function __construct(CatedraticoServiceInterface $servicio) {
        $this->servicio = $servicio;
    }

    public function manejar($method, $data) {
        switch ($method) {
            case 'GET':    return $this->servicio->obtenerCatedraticos();
            case 'POST':   return $this->servicio->agregarCatedraticos($data ?? []);
            case 'PUT':    return $this->servicio->actualizarCatedratico($data ?? []);
            case 'DELETE': return isset($data['id'])
                                ? $this->servicio->eliminarCatedratico((int)$data['id'])
                                : ["success" => false, "errores" => ["ID no proporcionado"]];
            default:       return ["error" => "Método no soportado"];
        }
    }
}
