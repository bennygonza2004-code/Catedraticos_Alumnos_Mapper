<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Validadores/CatedraticoValidator.php';
require_once __DIR__ . '/../Entidades/Catedratico.php';

class CatedraticoService implements CatedraticoServiceInterface {
    private CatedraticoRepositoryInterface $repo;
    private CatedraticoValidator $validator;

    public function __construct(CatedraticoRepositoryInterface $repo, CatedraticoValidator $validator) {
        $this->repo = $repo;
        $this->validator = $validator;
    }

    /** @return array<int, array<string,mixed>> */
    public function obtenerCatedraticos() {
        $entidades = $this->repo->obtenerTodos();
        $out = [];
        foreach ($entidades as $c) {
            $out[] = $this->toEntityArray($c);
        }
        return $out;
    }

    /** @param mixed $data @return array{success: bool, errores?: array<int,string>} */
    public function agregarCatedraticos($data) {
        $lista = isset($data[0]) ? $data : [$data];
        foreach ($lista as $c) {
            $errores = $this->validator->validateCreate($c);
            if ($errores) return ["success" => false, "errores" => $errores];

            $entidad = $this->fromArray($c);
            if (!$this->repo->insertar($entidad)) {
                return ["success" => false];
            }
        }
        return ["success" => true];
    }

    /** @param mixed $data @return array{success: bool, errores?: array<int,string>} */
    public function actualizarCatedratico($data) {
        $errores = $this->validator->validateUpdate($data);
        if ($errores) return ["success" => false, "errores" => $errores];

        $entidad = $this->fromArray($data);
        return ["success" => (bool)$this->repo->actualizar($entidad)];
    }

    /** @return array{success: bool} */
    public function eliminarCatedratico($id) {
        return ["success" => (bool)$this->repo->eliminar($id)];
    }

    // ---------- helpers ----------

    private function toEntityArray(Catedratico $c): array {
        return [
            'id'           => $c->id,
            'nombre'       => $c->nombre,
            'especialidad' => $c->especialidad,
            'correo'       => $c->correo,
        ];
    }

    /** @param array<string,mixed> $c */
    private function fromArray(array $c): Catedratico {
        return new Catedratico(
            isset($c['id']) ? (int)$c['id'] : null,
            (string)($c['nombre'] ?? ''),
            (string)($c['especialidad'] ?? ''),
            (string)($c['correo'] ?? '')
        );
    }
}
