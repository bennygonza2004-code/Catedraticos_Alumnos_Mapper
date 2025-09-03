<?php
interface ReadRepositoryInterface {
    public function obtenerTodos();
}

interface WriteRepositoryInterface {
    public function insertar($data);
    public function actualizar($data);
    public function eliminar($id);
}

/** Repositorios específicos (permiten tipado claro por entidad) */
interface AlumnoRepositoryInterface extends ReadRepositoryInterface, WriteRepositoryInterface {}
interface CatedraticoRepositoryInterface extends ReadRepositoryInterface, WriteRepositoryInterface {}
