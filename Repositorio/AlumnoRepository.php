<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Mappers/AlumnoMapper.php';
require_once __DIR__ . '/../Entidades/Alumno.php';

class AlumnoRepository implements AlumnoRepositoryInterface {
    private \mysqli $db;
    private AlumnoMapper $mapper;

    public function __construct(\mysqli $conexion, ?AlumnoMapper $mapper = null) {
        $this->db = $conexion;
        $this->mapper = $mapper ?? new AlumnoMapper();
    }

    /** @return Alumno[] */
    public function obtenerTodos() {
        $sql = "SELECT id, nombre, carnet, carrera, fecha_ingreso FROM alumnos ORDER BY id DESC";
        $res = $this->db->query($sql);
        if (!$res) return [];

        $lista = [];
        while ($row = $res->fetch_assoc()) {
            $lista[] = $this->mapper->mapRowToEntity($row);
        }
        $res->free();
        return $lista;
    }

    /** @param array|Alumno $alumno */
    public function insertar($alumno) {
        $data = is_object($alumno) ? $this->mapper->mapEntityToArray($alumno) : $alumno;

        $stmt = $this->db->prepare(
            "INSERT INTO alumnos (nombre, carnet, carrera, fecha_ingreso) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss",
            $data['nombre'], $data['carnet'], $data['carrera'], $data['fecha_ingreso']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /** @param array|Alumno $alumno */
    public function actualizar($alumno) {
        $data = is_object($alumno) ? $this->mapper->mapEntityToArray($alumno) : $alumno;

        $stmt = $this->db->prepare(
            "UPDATE alumnos SET nombre=?, carnet=?, carrera=?, fecha_ingreso=? WHERE id=?"
        );
        $stmt->bind_param("ssssi",
            $data['nombre'], $data['carnet'], $data['carrera'], $data['fecha_ingreso'], $data['id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM alumnos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
