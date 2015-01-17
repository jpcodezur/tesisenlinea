<?php

namespace Usuarios\Model\Entity;

class Puntaje {

    // <editor-fold defaultstate="collapsed" desc="Properties">

    private $id;
    private $idEvaluacion;
    private $idTopico;
    private $puntaje;
    private $comentarios;

    // </editor-fold>
    
    public function getId() {
        return $this->id;
    }

    public function getIdEvaluacion() {
        return $this->idEvaluacion;
    }

    public function getIdTopico() {
        return $this->idTopico;
    }

    public function getPuntaje() {
        return $this->puntaje;
    }

    public function getComentarios() {
        return $this->comentarios;
    }
    

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdEvaluacion($idEvaluacion) {
        $this->idEvaluacion = $idEvaluacion;
    }

    public function setIdTopico($idTopico) {
        $this->idTopico = $idTopico;
    }

    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }

    public function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }
   

}