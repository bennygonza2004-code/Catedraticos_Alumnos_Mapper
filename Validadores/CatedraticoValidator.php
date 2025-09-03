<?php
class CatedraticoValidator {
    public function validateCreate(array $c): array {
        $errores = [];
        if (empty($c['nombre'])) $errores[] = "nombre requerido";
        if (empty($c['especialidad'])) $errores[] = "especialidad requerida";
        if (empty($c['correo']) || !filter_var($c['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "correo inválido";
        }
        return $errores;
    }

    public function validateUpdate(array $c): array {
        $errores = [];
        if (empty($c['id'])) $errores[] = "id requerido";
        return array_merge($errores, $this->validateCreate($c));
    }
}
