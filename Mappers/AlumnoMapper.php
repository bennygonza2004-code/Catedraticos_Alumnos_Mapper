<?php
declare(strict_types=1);

require_once __DIR__ . '/MapperInterfaces.php';
require_once __DIR__ . '/../Entidades/Alumno.php';

final class AlumnoMapper implements EntityMapperInterface {
    /** @return Alumno */
    public function mapRowToEntity(array $row): object {
        return new Alumno(
            isset($row['id']) ? (int)$row['id'] : null,
            (string)($row['nombre'] ?? ''),
            (string)($row['carnet'] ?? ''),
            (string)($row['carrera'] ?? ''),
            (string)($row['fecha_ingreso'] ?? '')
        );
    }

    public function mapEntityToArray(object $entity): array {
        /** @var Alumno $entity */
        return [
            'id'            => $entity->id,
            'nombre'        => $entity->nombre,
            'carnet'        => $entity->carnet,
            'carrera'       => $entity->carrera,
            'fecha_ingreso' => $entity->fecha_ingreso,
        ];
    }
}
