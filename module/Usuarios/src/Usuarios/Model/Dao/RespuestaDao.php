<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Input;

class RespuestaDao {

    private $adapter;

    public function __construct($adapter) {
        $this->adapter = $adapter;
    }

    public function saveTexto($idRespuesta, $texto) {
        $sql = "INSERT INTO respuesta_texto (id_respuesta,texto) VALUES ($idRespuesta,'".$texto."')";
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

                $sql = "INSERT INTO respuestas(id_input,tipo,id_usuario,estado) VALUES($idInput,'" . $tipo . "','" . $idUsuario . "',1)";
                $res = $this->adapter->query($sql)->execute();
                $idRespuesta = $connection->getLastGeneratedValue();

                if ($res) {
                    if ($tipo == "texto") {
                        $res = $this->saveTexto($idRespuesta, $texto);
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
