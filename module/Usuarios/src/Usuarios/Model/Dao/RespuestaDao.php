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
    
    public function search($idInput){
        $sql = "SELECT id FROM respuestas WHERE estado=1 AND id_input=$idInput";
        $result = $this->adapter->query($sql)->execute();
         
        foreach($result as $r){
            return $r["id"];
        }
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
                    $sql = "INSERT INTO respuestas(id_input,tipo,id_usuario,estado) VALUES($idInput,'" . $tipo . "','" . $idUsuario . "',1)";
                }else{
                    $sql = "UPDATE respuestas set id_input=$idInput,tipo='" . $tipo . "',id_usuario='" . $idUsuario . "',estado=1";
                }
                
                $res = $this->adapter->query($sql)->execute();
                
                $idRespuesta = $update;
                
                if(!$update){
                    $idRespuesta = $connection->getLastGeneratedValue();
                }

                if ($res) {
                    if ($tipo == "texto") {
                        $res = $this->saveTexto($idRespuesta, $texto,$update);
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
