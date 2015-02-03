<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Input;

class FormularioEditDao {

    private $adapter;
    
    public function __construct($adapter) {
        $this->adapter = $adapter;
    }
    
    public function saveOrdenPaginas($paginas){
        foreach($paginas as $pagina){
            $sql = "UPDATE paginas set orden = ".$pagina["orden"]." WHERE id= ".$pagina["id"];
            $res = $this->adapter->query($sql);
            $result = $res->execute();
            if(!$result){
                return false;
            }
        }
        
        return true;
    }
    
    public function saveOrdenItems($inputs){
        foreach($inputs as $input){
            $sql = "UPDATE inputs set orden = ".$input["orden"]." WHERE id= ".$input["id"];
            $res = $this->adapter->query($sql);
            $result = $res->execute();
            if(!$result){
                return false;
            }
        }
        
        return true;
    }
    
    public function getPaginas(){
        $sql = "SELECT * FROM paginas WHERE estado = 1 ORDER BY orden ASC";
        
        $paginas = array();
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               $unaPagina = new Pagina();
               $unaPagina->setId($r["id"]);
               $unaPagina->setTitulo($r["titulo"]);
               $unaPagina->setEstado($r["estado"]);
               $unaPagina->setOrden($r["orden"]);
               $inputs = $this->getInputs($unaPagina->getId());
               $unaPagina->setInputs($inputs);
               $paginas[] = $unaPagina;
            }
        }
        
        return $paginas;
    }
    
    public function getPagina($id){
        $sql = "SELECT * FROM paginas WHERE estado = 1 AND id=$id ORDER BY orden ASC";
        
        $unaPagina = new Pagina;
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               $unaPagina->setId($r["id"]);
               $unaPagina->setTitulo($r["titulo"]);
               $unaPagina->setEstado($r["estado"]);
               $unaPagina->setOrden($r["orden"]);
               $inputs = $this->getInputs($unaPagina->getId());
               $unaPagina->setInputs($inputs);
               return $unaPagina;
            }
        }
        
        return $unaPagina;
    }
    
    public function getInputs($idPagina){
        $sql = "SELECT * FROM inputs WHERE estado = 1 AND id_pagina = $idPagina ORDER BY orden ASC";
        
        $inputs = array();
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               $unInput = new Input();
               $unInput->setId($r["id"]);
               $unInput->setIdPagina($r["id_pagina"]);
               $unInput->setLabel($r["label"]);
               $unInput->setEstado($r["estado"]);
               $unInput->setOrden($r["orden"]);
               $unInput->setNombre($r["nombre"]);
               $unInput->setRequired($r["required"]);
               $unInput->setTipo($r["tipo_input"]);
               
               $inputs[] = $unInput;
            }
        }
        
        return $inputs;
    }
    
    public function getInput($idinput){
        $sql = "SELECT * FROM inputs WHERE estado = 1 AND id = $idinput";
        
        $unInput = new Input();
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               $unInput->setId($r["id"]);
               $unInput->setIdPagina($r["id_pagina"]);
               $unInput->setLabel($r["label"]);
               $unInput->setEstado($r["estado"]);
               $unInput->setOrden($r["orden"]);
               $unInput->setNombre($r["nombre"]);
               $unInput->setRequired($r["required"]);
               $unInput->setTipo($r["tipo_input"]);
               
               return $unInput;
            }
        }
        
        return $inputs;
    }
    
}