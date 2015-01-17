<?php

namespace Usuarios\Model\Entity;

class Servidor{
    private $id;
    private $nombre;
    private $direccion;
    private $usuario;
    private $pass;
    private $db;
    
    function __construct($id="", $nombre="", $direccion="", $usuario="", $pass="", $db="") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->db = $db;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getDb() {
        return $this->db;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function setDb($db) {
        $this->db = $db;
    }



}