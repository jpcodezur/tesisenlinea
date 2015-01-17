<?php

namespace Usuarios\Model\Entity;
use Usuarios\Model\Dao\CampaniaDao;

class Campania {

    private $id;
    private $nombre;
    private $ubicacion;
    private $aprobacion;
    private $reprobacion;
    private $fechaReg;
    private $author;
    private $updated;
    private $updater;
    private $topicos;
    private $servidor;

    public function __construct($id = null, $nombre = null, $ubicacion = null, $reprobacion = null, $aprobacion = null, $fechaReg = null, $author = null, $updated = null, $updater = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
        $this->aprobacion = $aprobacion;
        $this->reprobacion = $reprobacion;
        $this->fechaReg = $fechaReg;
        $this->author = $author;
        $this->updated = $updated;
        $this->updater = $updater;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }
    
    public function getTopicos() {
        return $this->topicos;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function getAprobacion() {
        return $this->aprobacion;
    }

    public function getReprobacion() {
        return $this->reprobacion;
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
    
    public function getServidor() {
        return $this->servidor;
    }

    public function setNombre($param) {
        $this->nombre = $param;
    }

    public function setId($param) {
        $this->id = $param;
    }

    public function setUbicacion($param) {
        $this->ubicacion = $param;
    }

    public function setAprobacion($param) {
        $this->aprobacion = $param;
    }

    public function setReprobacion($param) {
        $this->reprobacion = $param;
    }
    
    public function setServidor($param) {
        $this->servidor = $param;
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
    
    public function setTopicos($array){
        $this->topicos=$array;
    }

}

