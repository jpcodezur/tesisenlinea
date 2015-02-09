<?php

namespace Usuarios\Model\Entity;

class Select{

    private $id;
    private $idInput;
    private $tipo;
    private $respuestasRequeridas;

    function getId() {
        return $this->id;
    }

    function getIdInput() {
        return $this->idInput;
    }

    function getTipo() {
        return $this->tipo;
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

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setRespuestasRequeridas($respuestasRequeridas) {
        $this->respuestasRequeridas = $respuestasRequeridas;
    }


}