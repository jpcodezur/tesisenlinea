<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Grupo;
use Usuarios\Model\Entity\Pregunta;

class FormularioDao {

    private $adapter;
    
    public function __construct($adapter) {
        $this->adapter = $adapter;
    }
    
    public function getLastPage($idUsuario){
        $sql = "select id_ultima_pagina_completa,terminado from usuario_formulario WHERE id_usuario = $idUsuario";
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               if(!$r["terminado"]){
                   return $r["id_ultima_pagina_completa"];
               }
           }
        }
        
        return false;
    }
    
    public function savePaginaCompletada($idUsuario,$idPagina,$terminado = false){
        if($this->getLastPage($idUsuario)){
            $sql = "UPDATE TABLE usuario_formulario, set id_ultima_pagina_completa=$idPagina,terminado=$terminado  WHERE id_usuario = $idUsuario";
        }else{
            $sql = "INSERT INTO usuario_formulario (id_usuario,id_ultima_pagina_completa,terminado) VALUES ($idUsuario,$idPagina,$terminado";
        }
        
        $res = $this->adapter->query($sql);
        return $res->execute();
    }


    public function getFormulario($idPagina){
        
    }
    
    public function getPaginas($getGrupo = true){
        
        $sql = "select * from paginas WHERE estado = 1";
        
        $paginas = array();
        
        $res = $this->adapter->query($sql);
        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $unaPagina = new Pagina();
                $unaPagina->setId($r["id"]);
                $unaPagina->setTitulo($r["titulo"]);
                if($getGrupo){
                    $unaPagina->grupos = $this->getGruposPorPagina($r["id"]);
                }
                $paginas[] = $unaPagina;
            }
        }
        
        return $paginas;
    }
    
    public function getGruposPorPagina($idPagina,$id=null){
        
        $sql = "select * from grupos WHERE estado = 1 AND id_pagina=".$idPagina;
        
        if($id){
            $sql .= " AND id=".$id;
        }
        
        $grupos = array();
        
        $res = $this->adapter->query($sql);
        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $unGrupo = new Grupo();
                $unGrupo->setId($r["id"]);
                $unGrupo->setTitulo($r["titulo"]);
                $unGrupo->preguntas = $this->getPreguntasPorGrupo($r["id"]);
                $grupos[] = $unGrupo;
            }
        }
        
        return $grupos;
    }
    
    public function getPreguntasPorGrupo($idGrupo){
        
        $sql = "select * from preguntas WHERE estado = 1 AND id_grupo=".$idGrupo;
        
        $preguntas = array();
        
        $res = $this->adapter->query($sql);
        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $unaPregunta = new Pregunta();
                $unaPregunta->setId($r["id"]);
                $unaPregunta->setTitulo($r["titulo"]);
                $unaPregunta->setNombre($r["nombre"]);
                $preguntas[] = $unaPregunta;
            }
        }
        
        return $preguntas;
    }
    

}