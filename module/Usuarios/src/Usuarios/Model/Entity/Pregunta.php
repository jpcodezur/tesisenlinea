<?php

namespace Usuarios\Model\Entity;

class Pregunta {

    private $id;
    private $id_grupo;
    private $titulo;
    private $orden;
    private $estado;
    
    function getId() {
        return $this->id;
    }

    function getId_grupo() {
        return $this->id_grupo;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getOrden() {
        return $this->orden;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_grupo($id_grupo) {
        $this->id_grupo = $id_grupo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    
}

