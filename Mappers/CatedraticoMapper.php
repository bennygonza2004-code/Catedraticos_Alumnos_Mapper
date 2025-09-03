<?php
declare(strict_types=1);

require_once __DIR__ . '/MapperInterfaces.php';
require_once __DIR__ . '/../Entidades/Catedratico.php';

final class CatedraticoMapper implements EntityMapperInterface {
    /** @return Catedratico */
    public function mapRowToEntity(array $row): object {
        return new Catedratico(
            isset($row['id']) ? (int)$row['id'] : null,
            (string)($row['nombre'] ?? ''),
            (string)($row['especialidad'] ?? ''),
            (string)($row['correo'] ?? '')
        );
    }

    public function mapEntityToArray(object $entity): array {
        /** @var Catedratico $entity */
        return [
            'id'           => $entity->id,
            'nombre'       => $entity->nombre,
            'especialidad' => $entity->especialidad,
            'correo'       => $entity->correo,
        ];
    }
}
