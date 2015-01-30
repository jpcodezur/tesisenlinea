<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Input;
use Usuarios\MisClases\Respuesta;
use Usuarios\Model\Dao\Validators\SaveInput;
use Usuarios\Model\Dao\Validators\EditInput;
use Usuarios\Controller\Params\InputParams;

class InputDao {

    private $adapter;

    public function __construct($adapter) {
        $this->adapter = $adapter;
        $this->params = new InputParams();
        $this->params = $this->params->getParams();
    }

    public function save($unaEntity) {

        $validate = new SaveInput("", $this, $this->params);

        $respuesta = $validate->validate($unaEntity);

        $respuesta->id = false;

        if ($respuesta->getError() === false) {

            /* Save Start */

            $connection = $this->adapter->getDriver()->getConnection();

            $connection->beginTransaction();

            $sql = "INSERT INTO inputs (nombre,label,required,tipo_input,estado,orden,id_pagina) VALUES(";

            $sql .= "'" . $unaEntity->getNombre() . "',";
            $sql .= "'" . $unaEntity->getLabel() . "',";
            $sql .= "'" . $unaEntity->getRequired() . "',";
            $sql .= "'" . $unaEntity->getTipo() . "',";
            $sql .= "'" . $unaEntity->getEstado() . "',";
            $sql .= "'" . $unaEntity->getOrden() . "',";
            $sql .= "'" . $unaEntity->getIdPagina() . "'";
            $sql .= ")";

            $result = $this->adapter->query($sql)->execute();

            if ($result) {

                $respuesta->id = $connection->getLastGeneratedValue();
                
                $unInput = $unaEntity->getControl();
                
                $unInput->setIdInput($respuesta->id);

                $respuesta = $this->saveInputType($unInput,$unaEntity->getTipo());

                if ($respuesta->getError() == true) {
                    $connection->rollback();
                } else {
                    $connection->commit();
                }
            } else {
                $connection->rollback();
            }

            /* End Save */
            if ($respuesta->getError() == false) {
                $respuesta->setError(false);
                $respuesta->setMensaje(ucwords($this->params["singular"]) . " saved successfully");
            }
            
            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error saving item");
            }
        }

        return $respuesta;
    }
    
    public function saveInputType($entity,$tipo){
        $response = new \Usuarios\MisClases\Respuesta();
        $response->setError(true);
        $sql = "";
        
        switch ($tipo) {
            case "texto":
                $sql = "INSERT INTO input_texto (id_input,respuestas_requeridas) ";
                $sql .= "VALUES ('".$entity->getIdInput()."','".$entity->getRespuestasRequeridas()."')";
                $result = $this->adapter->query($sql)->execute();
                if($result){
                    $response->setError(false);
                }
                
                break;

            default:
                break;
        }
        
        return $response;
    }

    public function fetchOneLike($query) {
        $sql = "SELECT * FROM inputs WHERE estado = 1 AND nombre LIKE '%" . $query . "%' ORDER BY nombre DESC";

        $paginas = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $entity) {
                return array(
                    "id" => $entity["id"],
                    "name" => $entity["nombre"],
                    "avatar" => "",
                    "icon" => "",
                    "type" => "");
            }
        }

        return $paginas;
    }

    public function fetchOne($array) {
        $flag = false;
        $sql = "SELECT * FROM inputs WHERE ";

        foreach ($array as $key => $value) {
            if ($flag) {
                $sql .= " AND $key = '" . $value . "'";
            } else {
                $sql .= " $key = '" . $value . "'";
            }

            $flag = true;
        }

        $sql .= " AND estado = 1";


        $inputs = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $entity) {
                $unInput = new Input();
                $unInput->setId($entity["id"]);
                $unInput->setIdPagina($entity["id_pagina"]);
                $unInput->setLabel($entity["label"]);
                $unInput->setEstado($entity["estado"]);
                $unInput->setNombre($entity["nombre"]);
                $unInput->setOrden($entity["orden"]);
                $unInput->setRequired($entity["required"]);
                $unInput->setTipo($entity["tipo_input"]);

                $inputs[] = $unInput;
            }
        }

        return $inputs;
    }

}
