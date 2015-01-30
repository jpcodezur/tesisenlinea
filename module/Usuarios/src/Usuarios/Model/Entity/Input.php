<?php

namespace Usuarios\Model\Entity;

class Input {
    
    private $id;
    private $nombre;
    private $idPagina;
    private $label;
    private $orden;
    private $estado;
    private $required;
    private $tipo;
    private $control;
    private $respuesta;
    
    function getRespuesta() {
        return $this->respuesta;
    }

    function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }

        
    function getControl() {
        return $this->control;
    }

    function setControl($control) {
        $this->control = $control;
    }

    
    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getId() {
        return $this->id;
    }

    function getIdPagina() {
        return $this->idPagina;
    }

    function getLabel() {
        return $this->label;
    }

    function getOrden() {
        return $this->orden;
    }

    function getEstado() {
        return $this->estado;
    }

    function getRequired() {
        return $this->required;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdPagina($idPagina) {
        $this->idPagina = $idPagina;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setRequired($required) {
        $this->required = $required;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    
    
    

}
