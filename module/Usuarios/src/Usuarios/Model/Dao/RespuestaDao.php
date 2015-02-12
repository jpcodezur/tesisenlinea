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
            $sql = "UPDATE respuesta_texto set id_respuesta=$idRespuesta,texto='".$texto."'";
        }
        
        return $this->adapter->query($sql)->execute();
    }
    
    public function saveDropdown($idRespuesta, $texto,$update) {
        if(!$update){
            $sql = "INSERT INTO respuesta_select (id_respuesta,id_select) VALUES ($idRespuesta,'".$texto."')";
        }else{
            $sql = "UPDATE respuesta_select set id_respuesta=$idRespuesta,id_select='".$texto."'";
        }
        
        return $this->adapter->query($sql)->execute();
    }
    
    
    public function search($idInput){
        $sql = "SELECT COUNT(*) as total FROM respuestas WHERE estado=1 AND id_input=$idInput";
        $result = $this->adapter->query($sql)->execute();
         
        foreach($result as $r){
            return $r["total"];
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

}
