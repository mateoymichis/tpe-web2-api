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
}
