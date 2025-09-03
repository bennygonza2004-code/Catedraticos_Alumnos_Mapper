<?php
declare(strict_types=1);

/**
 * Mapper genérico: fila DB <-> Entidad
 * (Usa 'object' para permitir cualquier entidad de dominio)
 */
interface EntityMapperInterface {
    /** @param array<string,mixed> $row */
    public function mapRowToEntity(array $row): object;

    /** @return array<string,mixed> */
    public function mapEntityToArray(object $entity): array;
}
    