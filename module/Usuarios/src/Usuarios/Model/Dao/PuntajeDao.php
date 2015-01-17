<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Puntaje;
use Usuarios\Model\Entity\Topico;

class PuntajeDao extends BaseDao implements ITopicoDao {

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
        
    }

    public function obtenerPorId($id) {
        
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Metodos Propios">

    public function obtenerPuntajeTopico($id) {

        /**/
        $select = $this->tableGateway->getSql()->select();

        $select->where(array("puntaje.id_topico" => $id));
        
        /**/

        //$salida = $select->getSqlString();

        $rowset = $this->tableGateway->selectWith($select);

        $topico = $rowset->current();
        
        $unPuntaje = new Puntaje();
        
        $unPuntaje->setId($topico["id"]);
        $unPuntaje->setIdEvaluacion($topico["id_evaluacion"]);
        $unPuntaje->setIdTopico($topico["id_topico"]);
        $unPuntaje->setPuntaje($topico["puntaje"]);
        $unPuntaje->setComentarios($topico["comentarios"]);
                

        return $unPuntaje;
    }

    public function buscarPorNombre($nombre) {
        
    }

    public function guardar($puntaje) {

        $data = array(
            "id_evaluacion" => $puntaje->getIdEvaluacion(),
            "id_topico" => $puntaje->getIdTopico(),
            "puntaje" => $puntaje->getPuntaje(),
            "comentarios" => $puntaje->getComentarios());

        if ($this->tableGateway->insert($data)) {
            return array("error" => "0");
        }

        return array("error" => "1", "mensaje" => "Can't save Topic.");
    }
    
    public function update($puntaje) {

        $data = array(
            "id_evaluacion" => $puntaje->getIdEvaluacion(),
            "id_topico" => $puntaje->getIdTopico(),
            "puntaje" => $puntaje->getPuntaje(),
            "comentarios" => $puntaje->getComentarios());

        if ($this->tableGateway->update($data, array("id_topico" => $puntaje->getIdTopico(),"id_evaluacion"=>$puntaje->getIdEvaluacion()))) {
            return array("error" => "0", "puntaje" => $puntaje);
        }

        return array("error" => "1", "mensaje" => "Can't update Points.", "puntaje" => $puntaje);
    }

    // </editor-fold>

    public static function delete($id) {
        
    }

}