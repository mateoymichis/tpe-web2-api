<?php

class CelularesModel {
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost:33065;'.'dbname=tienda_celulares;', 'root', '');
    }

    public function getCelulares() {
        $sentencia = $this->db->prepare(("  SELECT c.id_celular, c.modelo, c.descripcion, c.imagen, m.nombre AS marca
                                            FROM celulares AS c
                                            JOIN marcas AS m ON c.marca_id = m.id_marca;"));
        $sentencia->execute();
        $celulares = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $celulares;
    }

    public function getDetalleCelular($id) {
        $sentencia = $this->db->prepare(("SELECT c.id_celular, c.modelo, c.descripcion, c.imagen, m.nombre AS marca
                                            FROM celulares AS c
                                            JOIN marcas AS m ON c.marca_id = m.id_marca
                                            WHERE id_celular=?"));
        $sentencia->execute(array($id));
        $celular = $sentencia->fetch(PDO::FETCH_OBJ);

        return $celular;
    }

    public function borrarCelular($id) {
        $sentencia = $this->db->prepare("DELETE FROM celulares WHERE id_celular=?");
        $sentencia->execute(array($id));
    }

    public function crearCelular($modelo, $descripcion, $imagen, $marca_id) {
        $sentencia = $this->db->prepare("INSERT INTO celulares(modelo, descripcion, imagen, marca_id)
                                        VALUES(?, ?, ?, ?)");
        $sentencia->execute(array($modelo, $descripcion, $imagen, $marca_id));
        return $this->db->lastInsertId();
    }

    public function editarCelular($modelo, $descripcion, $imagen, $marca_id, $id) {
        $sentencia = $this->db->prepare("UPDATE celulares SET modelo=?, descripcion=?, imagen=?, marca_id=?
                                        WHERE id_celular=?");
        $sentencia->execute(array($modelo, $descripcion, $imagen, $marca_id, $id));
    }
}
