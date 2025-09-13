<?php
require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../DTOs/AlumnoDTO.php';

class AlumnoController
{
    public function __construct(private AlumnoServiceInterface $servicio) {}

    public function manejar($method, $data)
    {
        switch ($method) {
            case 'GET': {
                $listaDTO = $this->servicio->obtenerAlumnos();
                return array_map(fn($dto) => $dto->toArray(), $listaDTO);
            }

            case 'POST': {
                $dto = AlumnoDTO::fromArray($data ?? []);
                $creado = $this->servicio->agregarAlumno($dto);
                return $creado->toArray();
            }

            case 'PUT': {
                $dto = AlumnoDTO::fromArray($data ?? []);
                $actual = $this->servicio->actualizarAlumno($dto);
                // ⬇️ Agregamos marca de tiempo local (Guatemala) en la respuesta
                return array_merge($actual->toArray(), [
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            case 'DELETE': {
                if (!isset($data['id'])) {
                    return ["success" => false, "errores" => ["ID no proporcionado"]];
                }
                $ok = $this->servicio->eliminarAlumno((int)$data['id']);
                return ["success" => $ok];
            }

            default:
                return ["error" => "Método no soportado"];
        }
    }
}
    