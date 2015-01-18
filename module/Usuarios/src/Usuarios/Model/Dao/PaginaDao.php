<?php

namespace Usuarios\Model\Dao;

use Usuarios\MisClases\Respuesta;

class PaginaDao {

    protected $tableGateway;
    protected $params;

    public function __construct($tableGateway = null, $adapter = null) {
        $this->tableGateway = $tableGateway;
    }
    
    public function setParams($params){
        $this->params = $params;
    }

    public function fetchAll() {

        $enties = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->where(array("estado" => "1"));

        $select->order('id ASC');

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        
        //$salida = $select->getSqlString();
        
        foreach ($this->tableGateway->selectWith($select) as $entity) {

            $unaEntity = new $this->params["entity"]();
            
            foreach ($this->params["attrs"] as $attr) {
                $set = "set" . ucwords($attr);
                $unaEntity->$set($entity[$attr]);
            }

            $enties[] = $unaEntity;
        }

        return array("entities" => $enties, "paginator" => $paginator);
    }

    public function fetchOne($param) {

        $select = $this->tableGateway->getSql()->select();

        $select->where($param);

        $entities = $this->tableGateway->selectWith($select);
        
        foreach ($entities as $entity) {

            $unaEntity = new $this->params["entity"]();
            
            foreach ($this->params["attrs"] as $attr) {
                $set = "set" . ucwords($attr);
                $unaEntity->$set($entity[$attr]);
            }

            return $unaEntity;
        }

        return false;
    }

    public function guardar($unaEntity) {
        
        $data = array();
        
        foreach ($this->params["add_attrs"] as $attr) {
            $get = "get" . ucwords($attr);
            $data[$attr] = $unaEntity->$get();
        }
        
        $saveValidator = "\Usuarios\Model\Dao\Validators\Save" . $this->params["controller"];
        
        $validate = new $saveValidator($this->tableGateway, $this, $this->params);
        
        $respuesta = $validate->validate($unaEntity);
        
        if($respuesta->getError() === false){

            $result = $this->tableGateway->insert($data);

            $respuesta->setError(false);
            $respuesta->setMensaje(ucwords($this->params["singular"])." saved successfully");

            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error creating ".$this->params["singular"]);
            }
        }

        return $respuesta;
    }

    public function update($unaEntity) {
        
        $data = array();
        
        foreach ($this->params["edit_attrs"] as $attr) {
            $get = "get" . ucwords($attr);
            $data[$attr] = $unaEntity->$get();
        }
        
        $editValidator = "\Usuarios\Model\Dao\Validators\Edit" . $this->params["controller"];
        
        $validate = new $editValidator($this->tableGateway, $this, $this->params);
        
        $respuesta = $validate->validate($unaEntity);
        
        if($respuesta->getError() === false){

            $result = $this->tableGateway->update($data, array("id" => $unaEntity->getId()));

            $respuesta->setError(false);
            $respuesta->setMensaje(ucwords($this->params["singular"])." saved successfully");

            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error saving ".$this->params["singular"]);
            }
        }

        return $respuesta;
    }

    public function delete($id) {
        $respuesta = new Respuesta();

        $result = $this->tableGateway->update(array("estado" => "0"), array("id" => $id));
        
        $respuesta->setError(false);
        $respuesta->setMensaje(ucwords($this->params["singular"])." deleted successfully");
        
        if (!$result) {
            $respuesta->setError(true);
            $respuesta->setMensaje("Error deleting user");
        }

        return $respuesta;
    }

}
