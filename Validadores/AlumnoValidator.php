<?php
class AlumnoValidator {
    public function validateCreate(array $a): array {
        $errores = [];
        if (empty($a['nombre'])) $errores[] = "nombre requerido";
        if (empty($a['carnet'])) $errores[] = "carnet requerido";
        if (empty($a['carrera'])) $errores[] = "carrera requerida";
        if (empty($a['fecha_ingreso'])) $errores[] = "fecha_ingreso requerida";
        return $errores;
    }

    public function validateUpdate(array $a): array {
        $errores = [];
        if (empty($a['id'])) $errores[] = "id requerido";
        return array_merge($errores, $this->validateCreate($a));
    }
}
