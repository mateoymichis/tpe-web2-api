<?php

class MarcasModel {
    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost:33065;'.'dbname=tienda_celulares;', 'root', '');
    }

    public function getMarcas() {
        $sentencia = $this->db->prepare(("SELECT * FROM marcas"));
        $sentencia->execute();
        $marcas = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $marcas;
    }

    public function getNombresMarcas() {
        $sentencia = $this->db->prepare(("SELECT id_marca, nombre FROM marcas"));
        $sentencia->execute();
        $marcas = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $marcas;
    }

    public function getMarca($id) {
        $sentencia = $this->db->prepare(("SELECT * FROM marcas WHERE id_marca=?"));
        $sentencia->execute(array($id));
        $marca = $sentencia->fetch(PDO::FETCH_OBJ);

        return $marca;
    }

    public function getMarcaByName($name) {
        $sentencia = $this->db->prepare(("SELECT * FROM marcas WHERE nombre=?"));
        $sentencia->execute(array($name));
        $marca = $sentencia->fetch(PDO::FETCH_OBJ);

        return $marca;
    }

    public function crearMarca($nombre, $cuit) {
        $sentencia = $this->db->prepare("INSERT INTO marcas(nombre, cuit) VALUES(?, ?)");
        $sentencia->execute(array($nombre, $cuit));
        return $this->db->lastInsertId();
    }

    public function borrarMarca($id) {
        $sentencia = $this->db->prepare("DELETE FROM marcas WHERE id_marca=?");
        $sentencia->execute(array($id));
    }

    public function editarMarca($nombre, $cuit, $id) {
        $sentencia = $this->db->prepare("UPDATE marcas SET nombre=?, cuit=? WHERE id_marca=?");
        $sentencia->execute(array($nombre, $cuit, $id));
    }
}
