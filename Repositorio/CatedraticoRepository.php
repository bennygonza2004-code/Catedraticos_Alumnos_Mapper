<?php
declare(strict_types=1);

require_once __DIR__ . '/../Interfaces/RepositoryInterfaces.php';
require_once __DIR__ . '/../Mappers/MapperInterfaces.php';
require_once __DIR__ . '/../Mappers/CatedraticoMapper.php';
require_once __DIR__ . '/../Entidades/Catedratico.php';

class CatedraticoRepository implements CatedraticoRepositoryInterface {
    private \mysqli $db;
    private EntityMapperInterface $mapper;

    public function __construct(\mysqli $conexion, ?EntityMapperInterface $mapper = null) {
        $this->db     = $conexion;
        $this->mapper = $mapper ?? new CatedraticoMapper();
    }

    /** @return Catedratico[] */
    public function obtenerTodos() {
        $sql = "SELECT id, nombre, especialidad, correo FROM catedraticos ORDER BY id DESC";
        $res = $this->db->query($sql);
        if (!$res) return [];

        $lista = [];
        while ($row = $res->fetch_assoc()) {
            /** @var Catedratico $e */
            $e = $this->mapper->mapRowToEntity($row);
            $lista[] = $e;
        }
        $res->free();
        return $lista;
    }

    /** @param Catedratico $c */
    public function insertar($c) {
        $data = $this->mapper->mapEntityToArray($c);

        $stmt = $this->db->prepare(
            "INSERT INTO catedraticos (nombre, especialidad, correo) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $data['nombre'], $data['especialidad'], $data['correo']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /** @param Catedratico $c */
    public function actualizar($c) {
        $data = $this->mapper->mapEntityToArray($c);

        $stmt = $this->db->prepare(
            "UPDATE catedraticos SET nombre=?, especialidad=?, correo=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $data['nombre'], $data['especialidad'], $data['correo'], $data['id']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM catedraticos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
