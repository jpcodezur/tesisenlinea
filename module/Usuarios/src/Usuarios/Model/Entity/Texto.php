<?php

namespace Usuarios\Model\Entity;

class Texto{

    private $id;
    private $idInput;
    private $respuestasRequeridas;
    
    function getId() {
        return $this->id;
    }

    function getIdInput() {
        return $this->idInput;
    }

    function getRespuestasRequeridas() {
        return $this->respuestasRequeridas;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInput($idInput) {
        $this->idInput = $idInput;
    }

    function setRespuestasRequeridas($respuestasRequeridas) {
        $this->respuestasRequeridas = $respuestasRequeridas;
    }


    
}