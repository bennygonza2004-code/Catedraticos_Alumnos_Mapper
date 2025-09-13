<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Validadores/AlumnoValidator.php';
require_once __DIR__ . '/../Entidades/Alumno.php';
require_once __DIR__ . '/../DTOs/AlumnoDTO.php';
require_once __DIR__ . '/../Mappers/AlumnoMapper.php';

class AlumnoService implements AlumnoServiceInterface
{
    public function __construct(
        private AlumnoRepositoryInterface $repo,
        private AlumnoValidator $validator,
        private AlumnoMapper $mapper = new AlumnoMapper()
    ) {}

    /** @return AlumnoDTO[] */
    public function obtenerAlumnos(): array
    {
        $entidades = $this->repo->obtenerTodos(); // Alumno[]
        $out = [];
        foreach ($entidades as $a) {
            $out[] = $this->mapper->toDTO($a);
        }
        return $out;
    }

    public function agregarAlumno(AlumnoDTO $dto): AlumnoDTO
    {
        // Validación sobre DTO
        $errores = $this->validator->validateCreate($dto->toArray());
        if ($errores) {
            throw new InvalidArgumentException('Errores de validación: '.implode(', ', $errores));
        }

        // DTO -> Entidad -> persistencia
        $entidad = $this->mapper->fromDTO($dto);
        $row     = $this->mapper->mapEntityToArray($entidad);

        // Insertar
        $ok = $this->repo->insertar($row);
        if (!$ok) {
            throw new RuntimeException('No se pudo insertar Alumno');
        }

        // Tip: si tu repo devolviera el ID, acá lo asignás. (mysqli->insert_id)
        // Re-lee el registro recién insertado si necesitás el ID o versión canónica.
        // Para simpleza, devolvemos el mismo DTO.
        return $dto;
    }

    public function actualizarAlumno(AlumnoDTO $dto): AlumnoDTO
    {
        $errores = $this->validator->validateUpdate($dto->toArray());
        if ($errores) {
            throw new InvalidArgumentException('Errores de validación: '.implode(', ', $errores));
        }

        $entidad = $this->mapper->fromDTO($dto);
        $row     = $this->mapper->mapEntityToArray($entidad);

        $ok = $this->repo->actualizar($row);
        if (!$ok) {
            throw new RuntimeException('No se pudo actualizar Alumno');
        }

        return $dto;
    }

    public function eliminarAlumno(int $id): bool
    {
        return (bool)$this->repo->eliminar($id);
    }
}
