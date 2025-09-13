<?php
declare(strict_types=1);

/**
 * Data Transfer Object para Alumno.
 * Este objeto viaja entre Controller <-> Service, sin lógica de BD.
 */
final class AlumnoDTO
{
    public ?int $id;
    public string $nombre;
    public string $carnet;
    public string $carrera;
    public string $fecha_ingreso; // ISO (YYYY-MM-DD)

    public function __construct(?int $id, string $nombre, string $carnet, string $carrera, string $fecha_ingreso)
    {
        $this->id            = $id;
        $this->nombre        = $nombre;
        $this->carnet        = $carnet;
        $this->carrera       = $carrera;
        $this->fecha_ingreso = $fecha_ingreso;
    }

    /** Construye un DTO desde arreglo (payload JSON del front). */
    public static function fromArray(array $a): self
    {
        return new self(
            isset($a['id']) ? (int)$a['id'] : null,
            (string)($a['nombre'] ?? ''),
            (string)($a['carnet'] ?? ''),
            (string)($a['carrera'] ?? ''),
            (string)($a['fecha_ingreso'] ?? '')
        );
    }

    /** Exporta el DTO a arreglo listo para json_encode. */
    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'nombre'        => $this->nombre,
            'carnet'        => $this->carnet,
            'carrera'       => $this->carrera,
            'fecha_ingreso' => $this->fecha_ingreso,
        ];
    }
}
