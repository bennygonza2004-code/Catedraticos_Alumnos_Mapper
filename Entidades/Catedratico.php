<?php
declare(strict_types=1);

final class Catedratico {
    public ?int $id;
    public string $nombre;
    public string $especialidad;
    public string $correo;

    public function __construct(?int $id, string $nombre, string $especialidad, string $correo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->especialidad = $especialidad;
        $this->correo = $correo;
    }
}
