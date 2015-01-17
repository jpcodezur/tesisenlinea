<?php

namespace Usuarios\Model\Entity;

class Categoria {
    
    private $id,$nombre,$orden;
    
    public function setId($param){
        $this->id = $param;
    }
    
    public function setNombre($param){
        $this->nombre = $param;
    }
    
    public function setOrden($param){
        $this->orden = $param;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function getOrden(){
        return $this->orden;
    }
    
}