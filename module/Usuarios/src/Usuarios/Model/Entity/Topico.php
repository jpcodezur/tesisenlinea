<?php

namespace Usuarios\Model\Entity;

class Topico {
    
    // <editor-fold defaultstate="collapsed" desc="Properties">
    
    private $id;
    private $nombre;
    private $categoria;
    private $campania;
    private $puntaje;
    private $activa;
    private $fechaReg;
    private $author;
    private $updated;
    private $updater;
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Getters/Setters">
    
    public function setId($param) {
        $this->id = $param;
    }

    public function setNombre($param) {
        $this->nombre = $param;
    }

    public function setCategoria($param) {
        $this->categoria = $param;
    }
    
    public function setIdCategoria($param) {
        $this->categoria = $param;
    }

    public function setPuntaje($param) {
        $this->puntaje = $param;
    }

    public function setActiva($param) {
        $this->activa = $param;
    }

    public function setFechaReg($param) {
        $this->fechaReg = $param;
    }

    public function setAuthor($param) {
        $this->author = $param;
    }

    public function setUpdated($param) {
        $this->updated = $param;
    }

    public function setUpdater($param) {
        $this->updater = $param;
    }
	
    public function setCampania($param) {
        $this->campania = $param;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }
    
    public function getIdCategoria() {
        return $this->categoria;
    }

    public function getPuntaje() {
        return $this->puntaje;
    }

    public function getActiva() {
        return $this->activa;
    }

    public function getFechaReg() {
        return $this->fechaReg;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function getUpdater() {
        return $this->updater;
    }
    
    // </editor-fold>
    
}