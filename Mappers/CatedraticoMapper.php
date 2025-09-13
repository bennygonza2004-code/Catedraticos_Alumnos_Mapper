<?php
declare(strict_types=1);
require_once __DIR__ . '/../Entidades/Catedratico.php';
require_once __DIR__ . '/../DTOs/CatedraticoDTO.php';

final class CatedraticoMapper
{
    public function mapRowToEntity(array $row): Catedratico
    {
        return new Catedratico(
            isset($row['id']) ? (int)$row['id'] : null,
            (string)($row['nombre'] ?? ''),
            (string)($row['especialidad'] ?? ''),
            (string)($row['correo'] ?? '')
        );
    }

    public function mapEntityToArray(Catedratico $c): array
    {
        return [
            'id'           => $c->id,
            'nombre'       => $c->nombre,
            'especialidad' => $c->especialidad,
            'correo'       => $c->correo,
        ];
    }

    public function fromDTO(CatedraticoDTO $dto): Catedratico
    {
        return new Catedratico($dto->id, $dto->nombre, $dto->especialidad, $dto->correo);
    }

    public function toDTO(Catedratico $c): CatedraticoDTO
    {
        return new CatedraticoDTO($c->id, $c->nombre, $c->especialidad, $c->correo);
    }
}
