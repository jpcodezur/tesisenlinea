<?php

namespace Usuarios\Model\Entity;

class Imagen {

    private $id;
    private $idInput;
    private $archivo;
    
    function getId() {
        return $this->id;
    }

    function getIdInput() {
        return $this->idInput;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInput($idInput) {
        $this->idInput = $idInput;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }


}