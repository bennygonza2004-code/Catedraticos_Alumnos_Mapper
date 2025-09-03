<?php
declare(strict_types=1);

final class Alumno {
    public ?int $id;
    public string $nombre;
    public string $carnet;
    public string $carrera;
    public string $fecha_ingreso;

    public function __construct(?int $id, string $nombre, string $carnet, string $carrera, string $fecha_ingreso) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->carnet = $carnet;
        $this->carrera = $carrera;
        $this->fecha_ingreso = $fecha_ingreso;
    }
}
