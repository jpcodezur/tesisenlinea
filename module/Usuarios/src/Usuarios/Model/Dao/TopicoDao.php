<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Topico;
use Usuarios\Model\Entity\Categoria;
use ArrayObject;
use Zend\Db\TableGateway\TableGateway;

class TopicoDao extends BaseDao implements ITopicoDao {

    // <editor-fold defaultstate="collapsed" desc="Properties">

    protected $tableGateway;

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Constructor">

    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Metodos heredados de la interface">

    public function obtenerTodos() {

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('cat' => 'categorias'), 'cat.id = topicos.id_categoria', array('Categoria' => 'nombre')
        );

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);

        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unTopico = new Topico();
            $unTopico->setId($t["id"]);
            $unTopico->setNombre($t["nombre"]);
            $unTopico->setCategoria($t["Categoria"]);
            $unTopico->setPuntaje($t["puntaje"]);
            $unTopico->setActiva($t["activa"]);
            $unTopico->setFechaReg($t["fechaReg"]);
            $unTopico->setAuthor($t["author"]);
            $unTopico->setUpdated($t["updated"]);
            $unTopico->setUpdater($t["updater"]);
            $topicos[] = $unTopico;
        }

        return array("topicos" => $topicos, "paginator" => $paginator);
    }

    public function obtenerTopicosCampania($idCampania) {

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('cat' => 'categorias'), 'cat.id = topicos.id_categoria', array('Categoria' => 'nombre')
        );

        $select->join(
                array('tc' => 'topico_campania'), 'tc.id_topico = topicos.id', array('id_campania' => 'id_campania')
        );

        $select->join(
                array('c' => 'campanias'), 'c.id = tc.id_campania', array('Campania' => 'nombre')
        );

        $select->where(array('id_campania' => $idCampania));

        //die($select->getSqlString());

        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unTopico = new Topico();
            $unTopico->setId($t["id"]);
            $unTopico->setNombre($t["nombre"]);
            $unTopico->setCampania($t["Campania"]);
            $unTopico->setCategoria($t["Categoria"]);
            $unTopico->setPuntaje($t["puntaje"]);
            $unTopico->setActiva($t["activa"]);
            $unTopico->setFechaReg($t["fechaReg"]);
            $unTopico->setAuthor($t["author"]);
            $unTopico->setUpdated($t["updated"]);
            $unTopico->setUpdater($t["updater"]);
            $topicos[] = $unTopico;
        }

        return array("topicos" => $topicos);
    }

    public function obtenerTopicosEvaluacion($idEvaluacion) {
        
        $topicos = array();
        
        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('p' => 'puntaje'), 'p.id_topico = topicos.id', array('Resultado' => 'puntaje')
        );

        $select->join(
                array('e' => 'evaluaciones'), 'e.id = p.id_evaluacion', array('IdEvaluacion' => 'id')
        );
        
        $select->join(
                array('cat' => 'categorias'), 'cat.id = topicos.id_categoria', array('Categoria' => 'nombre')
        );

        $select->where(array('p.id_evaluacion' => $idEvaluacion));

        //die($select->getSqlString());

        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unTopico = new Topico();
            $unTopico->setId($t["id"]);
            $unTopico->setNombre($t["nombre"]);
            $unTopico->resultado=$t["Resultado"];
            $unTopico->setIdCategoria($t["id_categoria"]);
            $unTopico->setCategoria($t["Categoria"]);
            $unTopico->setPuntaje($t["puntaje"]);
            $unTopico->setActiva($t["activa"]);
            $unTopico->setFechaReg($t["fechaReg"]);
            $unTopico->setAuthor($t["author"]);
            $unTopico->setUpdated($t["updated"]);
            $unTopico->setUpdater($t["updater"]);
            $topicos[] = $unTopico;
        }

        return array("topicos" => $topicos);
    }

    public function obtenerPorId($id) {
        $topico = null;

        $select = $this->tableGateway->getSql()->select();

        $select->where(array("id" => $id));

        //$salida = $select->getSqlString();

        $rowset = $this->tableGateway->selectWith($select);

        return $this->toObject($rowset->current());
    }

    public function buscarPorNombre($nombre) {
        
    }

    public function guardar($topico) {

        $data = array(
            "nombre" => $topico->getNombre(),
            "id_categoria" => $topico->getCategoria(),
            "puntaje" => $topico->getPuntaje(),
            "activa" => "1",
            "fechaReg" => date("Y-m-d"),
            "updater" => "self");

        if ($this->tableGateway->insert($data)) {
            return array("error" => "0");
        }

        return array("error" => "1", "mensaje" => "Can't add Topic.");
    }

    public function update($topico) {

        $data = array(
            "nombre" => $topico->getNombre(),
            "puntaje" => $topico->getPuntaje(),
            "id_categoria" => $topico->getCategoria());

        if ($this->tableGateway->update($data, array("id" => $topico->getId()))) {
            return array("error" => "0", "topico" => $topico);
        }

        return array("error" => "1", "mensaje" => "Can't update Topic.", "topico" => $topico);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Metodos Propios">


    /*
     * Convierte una coleccion de objetos de tipo Topico en
     * un array id => value para agregarlo a los select en la view
     */
    public function ArrayObjectToSelect($col) {
        $array = array();

        foreach ($col as $item) {
            $array[$item->getId()] = $item->getNombre();
        }

        return $array;
    }

    // </editor-fold>

    public static function delete($id) {
        $sql = "DELETE FROM topicos WHERE id = " . $id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }

}