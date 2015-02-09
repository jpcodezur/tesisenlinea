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
    
    public function deleteTempSelectValue($idUsuario){
        $response = new \Usuarios\MisClases\Respuesta();
        
        $sql = "DELETE FROM input_select_temp WHERE id_input=".$idUsuario;
        
        $response->setError(true);
        
        $res = $this->adapter->query($sql)->execute();
        
        if($res){
            $sql = "DELETE FROM select_collections_temp WHERE id_input=".$idUsuario;
            $res = $this->adapter->query($sql)->execute();
            if($res){
                $response->setError(false);
                $response->setMensaje("");
            }
        }
        
        return $response;
    }
    
    public function deleteItemTempSelectValue($idUsuario,$idItem){
        $response = new \Usuarios\MisClases\Respuesta();
        
        $sql = "DELETE FROM input_select_temp WHERE id=$idItem AND id_input=".$idUsuario;
        
        $response->setError(true);
        
        $res = $this->adapter->query($sql)->execute();
        
        if($res){
            $response->setError(false);
            $response->setMensaje("");
        }
        
        return $response;
    }
    
    public function updateItemTempSelectValue($idUsuario,$idItem,$value,$tipo,$nrespuestas){
        $response = new \Usuarios\MisClases\Respuesta();
        
        $sql = "UPDATE input_select_temp ";
        $sql .= "set tipo=$tipo,valor=$value,respuestas_requeridas=$nrespuestas ";
        $sql .= "WHERE id=$idItem AND id_input=".$idUsuario;
        
        $response->setError(true);
        
        $res = $this->adapter->query($sql)->execute();
        
        if($res){
            $response->setError(false);
            $response->setMensaje("");
        }
        
        return $response;
    }
    
    public function searchInputTemp($idInput){
        $sql = "SELECT COUNT(*) as total FROM input_select_temp WHERE id_input = ".$idInput;
        $res = $this->adapter->query($sql);
        $total = 0;
        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $total = $r["total"];
            }
        }
        
        return $total;
        
    }
    
    public function insertTempSelectValue($idUsuario,$value,$tipo,$nrespuestas,$orden){
        $response = new \Usuarios\MisClases\Respuesta();
        
        $response->valor = $value;
        
        if(!$this->searchInputTemp($idUsuario)){
        
            $sql = "INSERT INTO input_select_temp (id_input,tipo,respuestas_requeridas) VALUES (";
            $sql .= "'".$idUsuario."',";
            $sql .= "'".$tipo."',";
            $sql .= "'".$nrespuestas."'";
            $sql .= ")";

            $response->setError(true);            

            $res = $this->adapter->query($sql)->execute();

            if($res){
                $response->setError(false);
                $response->setMensaje("");
            }
        
        }
        
        $idSelect = $orden;//$this->getIdSelect($idUsuario);
        
        if(!$idSelect){
            $idSelect = 0;
        }
                
        $sql = "INSERT INTO select_collections_temp (id_input,id_select,value) VALUES (";
        $sql .= "'".$idUsuario."',";
        $sql .= "'".($idSelect)."',";
        $sql .= "'".$value."'";
        $sql .= ")";

        $res = $this->adapter->query($sql)->execute();

        if($res){
            $response->idunput = $this->adapter->getDriver()->getLastGeneratedValue();
            $response->setError(false);
            $response->setMensaje("");
        }
        
        
        return $response;
    }
    
    public function saveOrdenValues($inputs){
        foreach($inputs as $input){
            $sql = "UPDATE select_collections_temp set 	id_select = ".$input["orden"]." WHERE id= ".$input["id"];
            $res = $this->adapter->query($sql);
            $result = $res->execute();
            if(!$result){
                return false;
            }
        }
        
        return true;
    }
    
    /*public function getIdSelect($id){
        $sql = "SELECT MAX(id_select) as maximo FROM select_collections_temp WHERE id_input = $id";
        $res = $this->adapter->query($sql)->execute();
        foreach($res as $r){
            return $r["maximo"];
        }
        
        return 0;
    }*/
    
    public function delete($id){
        
        $response = new \Usuarios\MisClases\Respuesta();
        
        $sql = "DELETE FROM inputs WHERE id = $id";
        
        $res = $this->adapter->query($sql)->execute();
        
        if($res){
            $response->setError(false);
            $response->setMensaje("Item eliminado");
        }
        
        return $response;
    }

    public function save($unaEntity) {

        $validate = new SaveInput("", $this, $this->params);

        $respuesta = $validate->validate($unaEntity);

        $respuesta->id = false;

        if ($respuesta->getError() === false) {

            /* Save Start */

            $connection = $this->adapter->getDriver()->getConnection();

            $connection->beginTransaction();

            $sql = "INSERT INTO inputs (nombre,label,required,tipo_input,estado,orden,id_pagina,ayuda) VALUES(";

            $sql .= "'" . $unaEntity->getNombre() . "',";
            $sql .= "'" . $unaEntity->getLabel() . "',";
            $sql .= "'" . $unaEntity->getRequired() . "',";
            $sql .= "'" . $unaEntity->getTipo() . "',";
            $sql .= "'" . $unaEntity->getEstado() . "',";
            $sql .= "'" . $unaEntity->getOrden() . "',";
            $sql .= "'" . $unaEntity->getIdPagina() . "',";
            $sql .= "'" . $unaEntity->getAyuda() . "'";
            $sql .= ")";

            $result = $this->adapter->query($sql)->execute();

            if ($result) {

                $id = $connection->getLastGeneratedValue();
                
                $unInput = $unaEntity->getControl();
                
                $unInput->setIdInput($id);

                $respuesta = $this->saveInputType($unInput,$unaEntity->getTipo());
                
                $respuesta->id = $id;

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
                $respuesta->setMensaje("Item saved successfully");
            }
            
            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error saving item");
            }
        }

        return $respuesta;
    }
    //($idusuario,$select["respuestas_requeridas"],$select["tipo"])
    public function saveSelect($idusuario,$idinput){
        $sql = "SELECT * FROM input_select_temp WHERE id_input=$idusuario";
        
        $res = $this->adapter->query($sql);
        
        $select = new \stdClass;
        
        if ($res) {
            $result = $res->execute();
            foreach ($result as $s) {
                $select->id = $s["id"];
                $select->id_input = $s["id_input"];
                $select->tipo = $s["tipo"];
                $select->respuestas_requeridas = $s["respuestas_requeridas"];
                
                $sql = "INSERT INTO input_select (id_input,tipo,respuestas_requeridas) VALUES (";
                $sql .= "'".$select->id_input."',";
                $sql .= "'".$select->tipo."',";
                $sql .= "'".$select->respuestas_requeridas."'";
                $sql .= ")";
                $resS = $this->adapter->query($sql)->execute();
            }
            
            $sql = "SELECT * FROM select_collections_temp WHERE id_input=$idusuario"; 
            $res = $this->adapter->query($sql);
            $results = $res->execute();
            foreach ($results as $s) {
                $sql = "INSERT INTO select_collections (id_input,id_select,value) VALUES (";
                $sql .= "'".$s["id_input"]."',";
                $sql .= "'".$s["id_select"]."',";
                $sql .= "'".$s["value"]."'";
                $sql .= ")";
                $resS = $this->adapter->query($sql)->execute();
            }
                
        }
        
        return true;
    }
    
    public function update($unaEntity) {

        $validate = new EditInput("", $this, $this->params);

        $unaEntity->setOrden(0);
        
        $respuesta = $validate->validate($unaEntity);

        $respuesta->id = false;

        if ($respuesta->getError() === false) {

            /* Save Start */

            $connection = $this->adapter->getDriver()->getConnection();

            $connection->beginTransaction();

            $sql = "UPDATE inputs set required = '".$unaEntity->getRequired()."', nombre='" . $unaEntity->getNombre() . "',label='" . $unaEntity->getLabel() . "',ayuda='" . $unaEntity->getAyuda() . "'";
            $sql .= " WHERE id =" . $unaEntity->getId();
            
            $result = $this->adapter->query($sql)->execute();

            if ($result) {

                $id = $unaEntity->getId();
                
                $unInput = $unaEntity->getControl();
                
                $unInput->setIdInput($id);

                $respuesta = $this->updateInputType($unInput,$unaEntity->getTipo());
                
                $respuesta->id = $id;

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
                $respuesta->setMensaje("Item updated successfully");
            }
            
            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error updating item");
            }
        }

        return $respuesta;
    }
    
    public function updateInputType($entity,$tipo){
        $response = new \Usuarios\MisClases\Respuesta();
        $response->setError(true);
        $sql = "";
        
        switch ($tipo) {
            case "texto":
                $sql = "UPDATE input_texto set respuestas_requeridas='".$entity->getRespuestasRequeridas()."' WHERE id_input=".$entity->getIdInput()."";
                
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
