<?php
declare(strict_types=1);

// --- Interfaces de servicios (para tipado de los controllers) 
require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';

// --- Validadores
require_once __DIR__ . '/../Validadores/AlumnoValidator.php';
require_once __DIR__ . '/../Validadores/CatedraticoValidator.php';

// --- Mappers (por interfaz)
require_once __DIR__ . '/../Mappers/MapperInterfaces.php';
require_once __DIR__ . '/../Mappers/AlumnoMapper.php';
require_once __DIR__ . '/../Mappers/CatedraticoMapper.php';

// --- Repositorios (usan EntityMapperInterface)
require_once __DIR__ . '/../Repositorio/AlumnoRepository.php';
require_once __DIR__ . '/../Repositorio/CatedraticoRepository.php';

// --- Servicios
require_once __DIR__ . '/../Servicio/AlumnoService.php';
require_once __DIR__ . '/../Servicio/CatedraticoService.php';

// --- Controladores
require_once __DIR__ . '/../Controles/AlumnoController.php';
require_once __DIR__ . '/../Controles/CatedraticoController.php';

final class Container {
    private \mysqli $db;

    // (Opcional) cache de instancias
    private ?AlumnoController $alumnoCtrl = null;
    private ?CatedraticoController $catedraticoCtrl = null;

    public function __construct(\mysqli $conexion) {
        $this->db = $conexion;
    }

    public function alumnoController(): AlumnoController {
        if ($this->alumnoCtrl) return $this->alumnoCtrl;

        // Mapper por interfaz
        $mapper  = new AlumnoMapper();                       // implements EntityMapperInterface
        $repo    = new AlumnoRepository($this->db, $mapper); // repo depende de la interfaz
        $service = new AlumnoService($repo, new AlumnoValidator(), $mapper); // ← cambio

        $this->alumnoCtrl = new AlumnoController($service);
        return $this->alumnoCtrl;
    }

    public function catedraticoController(): CatedraticoController {
        if ($this->catedraticoCtrl) return $this->catedraticoCtrl;

        $mapper  = new CatedraticoMapper();
        $repo    = new CatedraticoRepository($this->db, $mapper);
        $service = new CatedraticoService($repo, new CatedraticoValidator(), $mapper); // ← cambio

        $this->catedraticoCtrl = new CatedraticoController($service);
        return $this->catedraticoCtrl;
    }
}
