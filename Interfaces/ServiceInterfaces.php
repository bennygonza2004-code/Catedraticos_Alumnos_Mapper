<?php
declare(strict_types=1);

require_once __DIR__ . '/../DTOs/AlumnoDTO.php';
require_once __DIR__ . '/../DTOs/CatedraticoDTO.php';

/**
 * Las capas superiores (Controllers) operan con DTOs.
 * Los Services reciben DTOs, mapean a Entidad -> Repositorio, y devuelven DTOs.
 */
interface AlumnoServiceInterface
{
    /** GET: lista de DTOs */
    /** @return AlumnoDTO[] */
    public function obtenerAlumnos(): array;

    /** POST: crea y devuelve el DTO creado (con id asignado si aplica) */
    public function agregarAlumno(AlumnoDTO $dto): AlumnoDTO;

    /** PUT: actualiza y devuelve el DTO actualizado */
    public function actualizarAlumno(AlumnoDTO $dto): AlumnoDTO;

    /** DELETE: solo bool de éxito */
    public function eliminarAlumno(int $id): bool;
}

interface CatedraticoServiceInterface
{
    /** @return CatedraticoDTO[] */
    public function obtenerCatedraticos(): array;

    public function agregarCatedratico(CatedraticoDTO $dto): CatedraticoDTO;

    public function actualizarCatedratico(CatedraticoDTO $dto): CatedraticoDTO;

    public function eliminarCatedratico(int $id): bool;
}
