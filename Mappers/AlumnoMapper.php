<?php
declare(strict_types=1);
require_once __DIR__ . '/../Entidades/Alumno.php';
require_once __DIR__ . '/../DTOs/AlumnoDTO.php';

/**
 * Mapper: fila BD <-> Entidad  y  DTO <-> Entidad  y  Entidad <-> array persistencia.
 */
final class AlumnoMapper
{
    /** array BD -> Entidad */
    public function mapRowToEntity(array $row): Alumno
    {
        return new Alumno(
            isset($row['id']) ? (int)$row['id'] : null,
            (string)($row['nombre'] ?? ''),
            (string)($row['carnet'] ?? ''),
            (string)($row['carrera'] ?? ''),
            (string)($row['fecha_ingreso'] ?? '')
        );
    }

    /** Entidad -> array (para repositorio/mysqli) */
    public function mapEntityToArray(Alumno $a): array
    {
        return [
            'id'            => $a->id,
            'nombre'        => $a->nombre,
            'carnet'        => $a->carnet,
            'carrera'       => $a->carrera,
            'fecha_ingreso' => $a->fecha_ingreso,
        ];
    }

    /** DTO -> Entidad (entrada al Service) */
    public function fromDTO(AlumnoDTO $dto): Alumno
    {
        return new Alumno($dto->id, $dto->nombre, $dto->carnet, $dto->carrera, $dto->fecha_ingreso);
    }

    /** Entidad -> DTO (salida del Service) */
    public function toDTO(Alumno $a): AlumnoDTO
    {
        return new AlumnoDTO($a->id, $a->nombre, $a->carnet, $a->carrera, $a->fecha_ingreso);
    }
}
