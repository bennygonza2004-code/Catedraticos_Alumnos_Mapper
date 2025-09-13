<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/ServiceInterfaces.php';
require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Validadores/CatedraticoValidator.php';
require_once __DIR__ . '/../Entidades/Catedratico.php';
require_once __DIR__ . '/../DTOs/CatedraticoDTO.php';
require_once __DIR__ . '/../Mappers/CatedraticoMapper.php';

class CatedraticoService implements CatedraticoServiceInterface
{
    public function __construct(
        private CatedraticoRepositoryInterface $repo,
        private CatedraticoValidator $validator,
        private CatedraticoMapper $mapper = new CatedraticoMapper()
    ) {}

    /** @return CatedraticoDTO[] */
    public function obtenerCatedraticos(): array
    {
        $entidades = $this->repo->obtenerTodos();
        $out = [];
        foreach ($entidades as $c) {
            $out[] = $this->mapper->toDTO($c);
        }
        return $out;
    }

    public function agregarCatedratico(CatedraticoDTO $dto): CatedraticoDTO
    {
        $errores = $this->validator->validateCreate($dto->toArray());
        if ($errores) {
            throw new InvalidArgumentException('Errores de validación: '.implode(', ', $errores));
        }

        $entidad = $this->mapper->fromDTO($dto);
        $row     = $this->mapper->mapEntityToArray($entidad);

        $ok = $this->repo->insertar($row);
        if (!$ok) {
            throw new RuntimeException('No se pudo insertar Catedrático');
        }
        return $dto;
    }

    public function actualizarCatedratico(CatedraticoDTO $dto): CatedraticoDTO
    {
        $errores = $this->validator->validateUpdate($dto->toArray());
        if ($errores) {
            throw new InvalidArgumentException('Errores de validación: '.implode(', ', $errores));
        }

        $entidad = $this->mapper->fromDTO($dto);
        $row     = $this->mapper->mapEntityToArray($entidad);

        $ok = $this->repo->actualizar($row);
        if (!$ok) {
            throw new RuntimeException('No se pudo actualizar Catedrático');
        }
        return $dto;
    }

    public function eliminarCatedratico(int $id): bool
    {
        return (bool)$this->repo->eliminar($id);
    }
}
