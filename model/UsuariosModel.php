<?php

class UsuariosModel {
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost:33065;'.'dbname=tienda_celulares;', 'root', '');
    }

    public function getByEmail($usuario) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email=?');
        $query->execute(array($usuario));

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function createUser($email, $pass) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $query = $this->db->prepare('INSERT INTO usuarios(email, password) VALUES (?, ?)');
        $query->execute(array($email, $hash));
        return $this->db->lastInsertId();
    }

}
