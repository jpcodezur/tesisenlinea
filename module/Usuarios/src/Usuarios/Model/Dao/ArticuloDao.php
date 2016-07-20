<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Articulo;

class ArticuloDao extends BaseDao implements IArticuloDao {

    private $listaCategoria;
    protected $tableGateway;
    private $adapter;

    public function __construct($tableGateway = null, $adapter = null) {
        $this->tableGateway = $tableGateway;
        $this->adapter = $adapter;
    }
    
    public function getCategorias() {
        $articulos = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->columns(array('categories'));
        $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
        //echo $sql->getSqlstringForSqlObject($select); die ;
        //$select->where(array("estado"=>"1"));

        $select->order('categories ASC');

        $this->listaCategoria = $this->tableGateway->selectWith($select);

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->listaCategoria as $cat) {
            $unArticulo = new Articulo();
            $unArticulo->setCategorias($cat["categories"]);
            $articulos[] = $unArticulo;
        }

        return array("categorias" => $articulos, "paginator" => $paginator);
    }

    public function getEstados(){
        $estados = array();
        $this->adapter = $this->tableGateway->getAdapter();

        $sql = "SELECT DISTINCT * FROM estados_publicacion";

        $res = $this->adapter->query($sql);

        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $estados[] = $r;
            }
        }

        return $estados;
    }

    public function getTotalArticulos($filtros=null){
        $total = false;
        $this->adapter = $this->tableGateway->getAdapter();

        $where = "";

        if($filtros["categorias"]){
            $where = "WHERE categories='".$filtros["categorias"]."'";
        }

        if($filtros["estado"]){
            if($where){
                $where .= " AND";
            }else{
                $where .= " WHERE";
            }

            $where .= " estado='".$filtros["estado"]."'";
        }

        $sql = "SELECT COUNT(*) as total FROM articulos $where";


        $res = $this->adapter->query($sql);

        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $total = $r["total"];
            }
        }

        return array("total" => $total);
    }



}
