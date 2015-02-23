<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Input;

class RespuestaDao {

    private $adapter;

    public function __construct($adapter) {
        $this->adapter = $adapter;
    }

    public function saveTexto($idRespuesta, $texto,$update) {
        if(!$update){
            $sql = "INSERT INTO respuesta_texto (id_respuesta,texto) VALUES ($idRespuesta,'".$texto."')";
        }else{
            $sql = "UPDATE respuesta_texto set texto='".$texto."' WHERE id_respuesta=".$idRespuesta;
        }
        
        return $this->adapter->query($sql)->execute();
    }
    
    public function getIdsRespuestasSelect($idRespuesta,$idSelect,$idAlumno){
        $sql = "SELECT rs.id_select FROM respuesta_select as rs "
                . "INNER JOIN respuestas as r on r.id = rs.id_respuesta "
                . "WHERE rs.id_respuesta =$idRespuesta AND r.id_usuario = $idAlumno";
        $res = $this->adapter->query($sql)->execute();
        $ids = array();
        foreach($res as $r){
            $ids[] = $r["id_select"];
        }
        
        return $ids;
    }
    
    public function respuestaSelectExist($t,$idRespuesta,$idAlumno){
        $sql = "SELECT rs.id FROM respuesta_select as rs INNER JOIN respuestas as r on r.id = rs.id_respuesta WHERE rs.id_respuesta =$idRespuesta AND rs.id_select=".$t." AND r.id_usuario=$idAlumno";
        $res = $this->adapter->query($sql)->execute();
        $ret = false;
        foreach($res as $r){
            $ret = $r["id"];
        }
        
        return $ret;
    }

    public function saveDropdown($idRespuesta, $texto,$update) {
        //$idRespuesta = $this->getIdRespuesta($idSelect);
        $sql = "";
        
        $idAlumno = null;

        if(isset($_SESSION["miSession"]["usuario"])){
            $idAlumno = $_SESSION["miSession"]["usuario"]->getId();
        }
        
        
        if(!$texto){
            $sql = "DELETE FROM respuesta_select WHERE id_respuesta=$idRespuesta;";
        }else{
        if(!is_array($texto)){
            if(!$update){
                $sql = "INSERT INTO respuesta_select (id_respuesta,id_select,id_usuario) VALUES ($idRespuesta,'".$texto."','".$idAlumno."')";
            }else{
                $sql = "UPDATE respuesta_select set id_select='".$texto."' WHERE id_respuesta=$idRespuesta";
            }
        }else{
            if(!$update){
                foreach($texto as $idSelect){
                    $sql .= "INSERT INTO respuesta_select (id_respuesta,id_select,id_usuario) VALUES ($idRespuesta,'".$idSelect."','".$idAlumno."');";
                }
            }else{
                foreach($texto as $idSelect){
                    $idRespuestaSelects = $this->getIdsRespuestasSelect($idRespuesta,$idSelect,$idAlumno);
                    foreach($idRespuestaSelects as $idRespuestaSelect){
                        if(!in_array($idRespuestaSelect, $texto)){
                            $sql = "DELETE FROM respuesta_select WHERE id_select='".$idRespuestaSelect."' AND id_respuesta=$idRespuesta;";
                        }
                    }
                }
                
                foreach($texto as $idSelect){
                    $updateSelect = $this->respuestaSelectExist($idSelect,$idRespuesta,$idAlumno);
                    if($updateSelect){
                        $sql .= "UPDATE respuesta_select set id_select='".$idSelect."' WHERE id_respuesta=$idRespuesta AND id=$updateSelect;";
                    }else{
                        $sql .= "INSERT INTO respuesta_select (id_select,id_respuesta,id_usuario) VALUES('".$idSelect."','".$idRespuesta."','".$idAlumno."');";
                    }
                    
                }
            }
        }
        }
        /*
            INSERT INTO respuesta_select (id_select,id_respuesta,id_usuario) VALUES('1','24','5');
         *  UPDATE respuesta_select set id_select='14' WHERE id_respuesta=24;
         *          */
        return $this->adapter->query($sql)->execute();
    }
    
    
    public function search($idInput){
        $sql = "SELECT id FROM respuestas WHERE estado=1 AND id_input=$idInput";
        $result = $this->adapter->query($sql)->execute();
         
        foreach($result as $r){
            return $r["id"];
        }
        
        return false;
    }

    public function updateRespuesta($idInput,$tipo,$idUsuario,$texto){
        $sql = "UPDATE respuestas set id_input=$idInput,tipo='" . $tipo . "',id_usuario='" . $idUsuario . "',estado=1 WHERE id_input=".$idInput;
        return $this->adapter->query($sql)->execute();
    }
    
    public function insertarRespuesta($idInput,$tipo,$idUsuario,$texto){
        $sql = "INSERT INTO respuestas(id_input,tipo,id_usuario,estado) VALUES($idInput,'" . $tipo . "','" . $idUsuario . "',1)";
        return $this->adapter->query($sql)->execute();
    }
    
    public function addRespuesta($post) {

        $response = new \Usuarios\MisClases\Respuesta();
        $response->setError(false);

            foreach ($post as $respuesta) {
                $idInput = $respuesta["id_input"];
                $tipo = $respuesta["tipo"];
                $idUsuario = $_SESSION["miSession"]["usuario"]->getId();
                $texto = $respuesta["texto"];
                $connection = $this->adapter->getDriver()->getConnection();

                $update = $this->search($idInput);
                
                if(!$update){
                    $res = $this->insertarRespuesta($idInput,$tipo,$idUsuario,$texto);
                }else{
                   $res = $this->updateRespuesta($idInput,$tipo,$idUsuario,$texto);
                }
                
                $idRespuesta = $update;
                
                if(!$update){
                    $idRespuesta = $connection->getLastGeneratedValue();
                }

                if ($res) {
                    if ($tipo == "texto") {
                        $res = $this->saveTexto($idRespuesta, $texto,$update);
                    }elseif ($tipo == "dropdown") {
                        $res = $this->saveDropdown($idRespuesta, $texto,$update);
                    }
                }
            }
        
        if ($res) {
            $response->setError(false);
            $response->setMensaje("Saved success");
        }

        return $response;
    }
    
    public function addRespuestas($post) {

        $response = new \Usuarios\MisClases\Respuesta();
        $response->setError(false);

        foreach ($post as $respuestas) {
            foreach ($respuestas as $respuesta) {
                $idInput = $respuesta["id_input"];
                $tipo = $respuesta["tipo"];
                $idUsuario = $_SESSION["miSession"]["usuario"]->getId();
                $texto = $respuesta["texto"];
                $connection = $this->adapter->getDriver()->getConnection();

                $update = $this->search($idInput);
                
                if(!$update){
                    $res = $this->insertarRespuesta($idInput,$tipo,$idUsuario,$texto);
                }else{
                   $res = $this->updateRespuesta($idInput,$tipo,$idUsuario,$texto);
                }
                
                $idRespuesta = $update;
                
                if(!$update){
                    $idRespuesta = $connection->getLastGeneratedValue();
                }

                if ($res) {
                    if ($tipo == "texto") {
                        $res = $this->saveTexto($idRespuesta, $texto,$update);
                    }elseif ($tipo == "dropdown") {
                        $res = $this->saveDropdown($idRespuesta, $texto,$update);
                    }
                }
            }
        }
        
        if ($res) {
            $response->setError(false);
            $response->setMensaje("Saved success");
        }

        return $response;
    }
    
    public function remplaceSpan($post){
        $nombre = $post["nom"];
        $tipo = $post["tipo"];
        
        switch ($tipo) {
            case "texto":
                $sql = "SELECT * FROM inputs as i "
                . "INNER JOIN respuestas as r on r.id_input = i.id "
                . "INNER JOIN respuesta_texto as rt on rt.id_respuesta = r.id "    
                . "WHERE i.nombre ='".$nombre."'";
                break;
            case "dropdown":
                $sql = "SELECT sc.value as texto FROM inputs as i "
                . "INNER JOIN respuestas as r on r.id_input = i.id "
                . "INNER JOIN respuesta_select as rs on rs.id_respuesta = r.id "    
                . "INNER JOIN select_collections as sc on sc.id_input = i.id AND sc.id_select = rs.id_select "
                . "WHERE i.nombre ='".$nombre."'";
                break;

            default:
                break;
        }
        
        $res = $this->adapter->query($sql)->execute();
        
        $obj  = new \stdClass();
         
        foreach($res as $r){
            return $r["texto"];
        }
        
        return false;
    }

}
