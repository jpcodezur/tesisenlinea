<?php

namespace Usuarios\Model\Entity;

class Pregunta {

    private $id;
    private $id_grupo;
    private $nombre;
    private $titulo;
    private $orden;
    private $requerida;
    private $es_pregunta;
    private $estado;
    
    function getId() {
        return $this->id;
    }

    function getId_grupo() {
        return $this->id_grupo;
    }
    
    function getEs_pregunta(){
        return $this->es_pregunta;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getOrden() {
        return $this->orden;
    }
    
    function getRequerida() {
        return $this->requerida;
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

    function setNombre($nombre) {
        $this->nombre = $nombre;
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
    
    function setRequerida($requerida) {
        $this->requerida = $requerida;
    }
    
    function setEs_pregunta($param){
        $this->es_pregunta = $param;
    }
    
    
    public function isRequired(){
        if($this->requerida){
            return true;
        }
        
        return false;
    }


    
}