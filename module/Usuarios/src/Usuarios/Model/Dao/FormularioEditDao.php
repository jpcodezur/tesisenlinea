<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Input;

class FormularioEditDao {

    private $adapter;
    
    public function __construct($adapter) {
        $this->adapter = $adapter;
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
    
    public function getInputs(){
        $sql = "SELECT * FROM inputs WHERE estado = 1 ORDER BY orden ASC";
        
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
               $unInput->setRequired($r["required"]);
               $unInput->setTipo($r["tipo_input"]);
               
               $inputs[] = $unInput;
            }
        }
        
        return $inputs;
    }
    
}