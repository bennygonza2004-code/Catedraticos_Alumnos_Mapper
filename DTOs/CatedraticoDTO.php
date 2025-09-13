<?php
declare(strict_types=1);

/**
 * Data Transfer Object para Catedrático.
 */
final class CatedraticoDTO
{
    public ?int $id;
    public string $nombre;
    public string $especialidad;
    public string $correo;

    public function __construct(?int $id, string $nombre, string $especialidad, string $correo)
    {
        $this->id           = $id;
        $this->nombre       = $nombre;
        $this->especialidad = $especialidad;
        $this->correo       = $correo;
    }

    public static function fromArray(array $c): self
    {
        return new self(
            isset($c['id']) ? (int)$c['id'] : null,
            (string)($c['nombre'] ?? ''),
            (string)($c['especialidad'] ?? ''),
            (string)($c['correo'] ?? '')
        );
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'nombre'       => $this->nombre,
            'especialidad' => $this->especialidad,
            'correo'       => $this->correo,
        ];
    }
}
 