<?php
require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../DTOs/CatedraticoDTO.php';

class CatedraticoController
{
    public function __construct(private CatedraticoServiceInterface $servicio) {}

    public function manejar($method, $data)
    {
        switch ($method) {
            case 'GET': {
                $listaDTO = $this->servicio->obtenerCatedraticos();
                return array_map(fn($dto) => $dto->toArray(), $listaDTO);
            }

            case 'POST': {
                $dto = CatedraticoDTO::fromArray($data ?? []);
                $creado = $this->servicio->agregarCatedratico($dto);
                return $creado->toArray();
            }

            case 'PUT': {
                $dto = CatedraticoDTO::fromArray($data ?? []);
                $actual = $this->servicio->actualizarCatedratico($dto);
                // ⬇️ Marca de tiempo de actualización
                return array_merge($actual->toArray(), [
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            case 'DELETE': {
                if (!isset($data['id'])) {
                    return ["success" => false, "errores" => ["ID no proporcionado"]];
                }
                $ok = $this->servicio->eliminarCatedratico((int)$data['id']);
                return ["success" => $ok];
            }

            default:
                return ["error" => "Método no soportado"];
        }
    }
}
