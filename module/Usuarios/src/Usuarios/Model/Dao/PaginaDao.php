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
            
            foreach ($this->params["add_attrs"] as $attr) {
                $set = "set" . ucwords($attr);
                $unaEntity->$set($entity[$attr]);
            }

            return $unaEntity;
        }

        return false;
    }

    public function guardar($unaEntity) {
        
        $respuesta = new Respuesta();
        
        $data = array();
        
        foreach ($this->params["add_attrs"] as $attr) {
            $get = "get" . ucwords($attr);
            $data[$attr] = $unaEntity->$get();
        }
        
        $validate = new \Usuarios\Model\Dao\Validators\SavePagina($this->tableGateway, $this, $this->params);
        
        $respuesta = $validate->validate($unaEntity);
        
        if($respuesta->getError() === false){

            $result = $this->tableGateway->insert($data);

            $respuesta->setError(false);
            $respuesta->setMensaje(ucwords($this->params["singular"])." saved successfully");

            if (!$result) {
                $respuesta->setError(true);
                $respuesta->setMensaje("Error deleting ".$this->params["singular"]);
            }
        }

        return $respuesta;
    }

    public function update($user) {
        $result = false;

        $data = array(
            "nombre" => $user->getNombre(),
            "apellido" => $user->getApellido(),
            "email" => $user->getEmail(),
            "tipo" => $user->getTipo(),
        );

        if ($user->getAvatar()) {
            $data["avatar"] = $user->getAvatar();
        }

        $result = $this->tableGateway->update($data, array("id" => $user->getId()));

        if ($result) {
            return array("error" => "0", "usuario" => $user);
        }

        return array("error" => "1", "usuario" => $user);
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
