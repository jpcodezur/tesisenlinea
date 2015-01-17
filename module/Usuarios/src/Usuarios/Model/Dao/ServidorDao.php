<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Servidor;

class ServidorDao extends BaseDao implements IServidorDao {
    
    private $tableGateway;
    
    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function buscarPorNombre($nombre) {

        $servidor = Connect::getInstance()->getObjectPorNombre($nombre, "origenes_datos");

        if ($servidor) {
            $unServidor = new Servidor();
            $unServidor->setNombre($servidor["nombre"]);
            $unServidor->setDireccion($servidor["direccion"]);
            $unServidor->setUsuario($servidor["usuario"]);
            $unServidor->setPass($servidor["pass"]);
            $unServidor->setDb($servidor["db"]);

            return $unServidor;
        }
        return false;
    }
    
    public function obtenerPorId($id) {
        $topico = null;

        $select = $this->tableGateway->getSql()->select();

        $select->where(array("id" => $id));

        //$salida = $select->getSqlString();

        $rowset = $this->tableGateway->selectWith($select);

        return $this->toObject($rowset->current());
    }
    
    public function obtenerTodos() {

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);

        $paginator = new \Zend\Paginator\Paginator($adapter);
        
        $servidores = array();
        
        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unServidor = new Servidor();
            $unServidor->setId($t["id"]);
            $unServidor->setNombre($t["nombre"]);
            $unServidor->setDireccion($t["direccion"]);
            $unServidor->setUsuario($t["usuario"]);
            $unServidor->setDb($t["db"]);
            $servidores[] = $unServidor;
        }

        return array("servidores" => $servidores, "paginator" => $paginator);
    }
    
    public function guardar($servidor) {

        $data = array(
            "nombre" => $servidor->getNombre(),
            "direccion" => $servidor->getDireccion(),
            "usuario" => $servidor->getUsuario(),
            "pass" => $servidor->getPass(),
            "db" => $servidor->getDb(),
            );

        if ($this->tableGateway->insert($data)) {
            return array("error" => "0");
        }

        return array("error" => "1", "mensaje" => "Can't add Server.");
    }
    
    public function update($servidor) {

        $data = array(
            "nombre" => $servidor->getNombre(),
            "direccion" => $servidor->getDireccion(),
            "usuario" => $servidor->getUsuario(),
            "pass" => $servidor->getPass(),
            "db" => $servidor->getDb(),
        );

        if ($this->tableGateway->update($data, array("id" => $servidor->getId()))) {
            return array("error" => "0", "servidor" => $servidor);
        }

        return array("error" => "1", "mensaje" => "Can't update Server.", "servidor" => $servidor);
    }
    
    public static function delete($id) {
        $sql = "DELETE FROM origenes_datos WHERE id = " . $id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }

}