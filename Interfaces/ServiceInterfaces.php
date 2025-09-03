<?php
interface AlumnoServiceInterface {
    public function obtenerAlumnos();
    public function agregarAlumnos($data);
    public function actualizarAlumno($data);
    public function eliminarAlumno($id);
}

interface CatedraticoServiceInterface {
    public function obtenerCatedraticos();
    public function agregarCatedraticos($data);
    public function actualizarCatedratico($data);
    public function eliminarCatedratico($id);
}
