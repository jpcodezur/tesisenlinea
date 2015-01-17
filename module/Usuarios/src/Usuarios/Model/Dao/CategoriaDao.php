<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Categoria;
use ArrayObject;
use Zend\Db\TableGateway\TableGateway;

class CategoriaDao extends BaseDao implements ICategoriaDao {

    protected $tableGateway;
    private $adapter;

    public function __construct($tableGateway = null, $adapter = null) {
        $this->tableGateway = $tableGateway;
        $this->adapter = $adapter;
    }

    public function obtenerTodos() {
        $categorias = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);

        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->tableGateway->selectWith($select) as $cat) {
            $unaCategoria = new Categoria();
            $unaCategoria->setId($cat["id"]);
            $unaCategoria->setNombre($cat["nombre"]);
            $unaCategoria->setOrden($cat["orden"]);
            $categorias[] = $unaCategoria;
        }

        return array("categorias" => $categorias, "paginator" => $paginator);
    }

    public function obtenerPorId($id) {
        return array();
    }

    public function buscarPorNombre($nombre) {
        return array();
    }

    public function guardar($categoria) {

        $data = array(
            "nombre" => $categoria->getNombre(),
            "orden" => $categoria->getOrden());

        if($this->tableGateway->insert($data)){
            return array("error"=>"0");
        }
        
        return array("error"=>"1","mensaje"=>"Can't add Categorie.");
    }
    
    public static function delete($id){
        $sql = "DELETE FROM categorias WHERE id = ".$id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }

}