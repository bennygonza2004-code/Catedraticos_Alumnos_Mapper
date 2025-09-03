<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Validadores/AlumnoValidator.php';
require_once __DIR__ . '/../Entidades/Alumno.php';

class AlumnoService implements AlumnoServiceInterface {
    private AlumnoRepositoryInterface $repo;
    private AlumnoValidator $validator;

    public function __construct(AlumnoRepositoryInterface $repo, AlumnoValidator $validator) {
        $this->repo = $repo;
        $this->validator = $validator;
    }

    /** @return array<int, array<string,mixed>> */
    public function obtenerAlumnos() {
        $entidades = $this->repo->obtenerTodos();
        $out = [];
        foreach ($entidades as $a) {
            $out[] = $this->toEntityArray($a);
        }
        return $out;
    }

    /** @param mixed $data @return array{success: bool, errores?: array<int,string>} */
    public function agregarAlumnos($data) {
        $lista = isset($data[0]) ? $data : [$data];
        foreach ($lista as $a) {
            $errores = $this->validator->validateCreate($a);
            if ($errores) return ["success" => false, "errores" => $errores];

            $entidad = $this->fromArray($a);         // ← array -> Entidad
            if (!$this->repo->insertar($entidad)) {  // ← repo recibe Entidad
                return ["success" => false];
            }
        }
        return ["success" => true];
    }

    /** @param mixed $data @return array{success: bool, errores?: array<int,string>} */
    public function actualizarAlumno($data) {
        $errores = $this->validator->validateUpdate($data);
        if ($errores) return ["success" => false, "errores" => $errores];

        $entidad = $this->fromArray($data);          // ← array -> Entidad
        return ["success" => (bool)$this->repo->actualizar($entidad)];
    }

    /** @return array{success: bool} */
    public function eliminarAlumno($id) {
        return ["success" => (bool)$this->repo->eliminar($id)];
    }

    // ---------- helpers ----------

    private function toEntityArray(Alumno $a): array {
        return [
            'id'            => $a->id,
            'nombre'        => $a->nombre,
            'carnet'        => $a->carnet,
            'carrera'       => $a->carrera,
            'fecha_ingreso' => $a->fecha_ingreso,
        ];
    }

    /** @param array<string,mixed> $a */
    private function fromArray(array $a): Alumno {
        $fecha = $this->normalizeFecha((string)($a['fecha_ingreso'] ?? ''));
        return new Alumno(
            isset($a['id']) ? (int)$a['id'] : null,
            (string)($a['nombre'] ?? ''),
            (string)($a['carnet'] ?? ''),
            (string)($a['carrera'] ?? ''),
            $fecha
        );
    }

    /** Acepta 'YYYY-MM-DD' o 'DD/MM/YYYY' y devuelve 'YYYY-MM-DD' */
    private function normalizeFecha(string $f): string {
        $f = trim($f);
        if ($f === '') return '';
        $dt = \DateTime::createFromFormat('Y-m-d', $f) ?: \DateTime::createFromFormat('d/m/Y', $f);
        return $dt ? $dt->format('Y-m-d') : $f;
    }
}
