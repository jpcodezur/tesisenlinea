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
        
        return $this->getLastPageOrden();
    }
    
    public function getLastPageOrden(){
        
        $sql = "SELECT id FROM paginas WHERE orden = (SELECT MIN(orden) as minimo FROM `paginas` WHERE estado = 1) AND estado = 1";
        
        $res = $this->adapter->query($sql);
        
        if($res){
           $result = $res->execute();
           foreach($result as $r){
               return $r["id"];
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
        $res = $this->getGruposPorPagina($idPagina);
        return $res;
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
    
    
    
    public function getPreguntaPadre($string){
        $separadores = array("?",".","!",":",";",",");
        
        $palabras = explode(" ", $string);
        
        $res = "";
        
        foreach($palabras as $palabra){
            if(strpos($palabra, "@") === 0){
                $palabra = substr($palabra, 1);
                foreach($separadores as $separador){
                    $pos = strpos($palabra, $separador);
                    if($pos !== false){
                        $palabra = substr($palabra, 0,$pos);
                    }
                }
                $respuesta[$string] = $this->getRespuestaPregunta($palabra);
            }
        }
        
        foreach($respuesta as $palabra){
            foreach($respuesta as $key => $value){
                if($key == $palabra){
                    $palabra = $value;
                }
                $res = $palabra. " ";
            }
        }
        
        
        return $res;
    }
    
    public function getRespuestaPregunta($nomPregunta,$idUsuario){
        $sql = "SELECT p.id as preguntaId,r.respuesta as respuesta FROM preguntas as p"
            . " INNER JOIN respuestas as r on r.id_preunta = p.id and r.id_usuario=".$idUsuario
            . " WEHRE p.nombre = $nomPregunta AND p.estado=1 AND r.estado = 1";
        
        $res = $this->adapter->query($sql);
        
        $retorno = "";
        
        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $retorno = $r["respuesta"];
            }
        }
        
        return $retorno;
    }
    
    public function getPreguntasPorGrupo($idGrupo,$idUsuario=null){
        
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