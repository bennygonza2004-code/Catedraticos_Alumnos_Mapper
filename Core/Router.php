<?php
class Router {
    private $container;
    public function __construct($container) { $this->container = $container; }

    public function dispatch($tipo, $method, $data) {
        switch ($tipo) {
            case 'alumno':
                return $this->container->alumnoController()->manejar($method, $data);
            case 'catedratico':
                return $this->container->catedraticoController()->manejar($method, $data);
            default:
                http_response_code(400);
                return ["error" => "Parámetro 'tipo' no válido"];
        }
    }
}
