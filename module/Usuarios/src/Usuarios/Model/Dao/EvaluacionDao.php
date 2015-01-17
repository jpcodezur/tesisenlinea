<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Evaluacion;
use ArrayObject;
use Zend\Db\TableGateway\TableGateway;

class EvaluacionDao extends BaseDao implements IEvaluacionDao {

    // <editor-fold defaultstate="collapsed" desc="Constructor">

    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Metodos heredados de la interface">
    
    public function obtenerTodos() {

        $evaluaciones = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('u' => 'usuarios'), 'u.id = evaluaciones.id_agente', array('AgenteNombre' => 'nombre', 'AgenteApellido' => 'apellido')
        );

        $select->join(
                array('c' => 'campanias'), 'c.id = evaluaciones.id_campania', array('Campania' => 'nombre', 'CampaniaId' => 'id', 'PuntajeCampaniaAprobacion' => 'aprobacion', 'PuntajeCampaniaReprobacion' => 'reprobacion')
        );

        $select->join(
                array('us' => 'usuarios'), 'us.id = evaluaciones.id_supervisor', array('EvaluadorNombre' => 'nombre', 'EvaluadorApellido' => 'apellido')
        );

        $select->order('id ASC');

        //$salida = $select->getSqlString();

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);

        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unaEvaluacion = new Evaluacion();
            $unaEvaluacion->setId($t["id"]);
            $unaEvaluacion->setCampania($t["Campania"]);
            $unaEvaluacion->setPuntajeCampania($this->getTotalPuntaje($t["CampaniaId"]));
            $unaEvaluacion->setFechaEvaluacion($t["fecha_evaluacion"]);
            $unaEvaluacion->setFechaLlamada($t["fecha_llamada"]);

            $unaEvaluacion->setPuntajeCampaniaAprobacion($t["PuntajeCampaniaAprobacion"]);
            $unaEvaluacion->setPuntajeCampaniaReprobacion($t["PuntajeCampaniaReprobacion"]);

            $unaEvaluacion->setAgente($t["AgenteNombre"] . " " . $t["AgenteApellido"]);

            $unaEvaluacion->setEvaluador($t["EvaluadorNombre"] . " " . $t["EvaluadorApellido"]);

            $resultado = $this->getResultado($t["id"]);

            $unaEvaluacion->setPuntaje($resultado);

            $unaEvaluacion->setNotificado($t["notificado"]);
            $unaEvaluacion->setLeido($t["leido"]);
            $unaEvaluacion->id_campania = $t["id_campania"];
            $unaEvaluacion->id_agente = $t["id_agente"];


            $evaluaciones[] = $unaEvaluacion;
        }

        return array("evaluaciones" => $evaluaciones, "paginator" => $paginator);
    }
    
    public function getEvaluacionesAgente($idAgente) {

        $evaluaciones = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('c' => 'campanias'), 'c.id = evaluaciones.id_campania', array('Campania' => 'nombre', 'CampaniaId' => 'id', 'PuntajeCampaniaAprobacion' => 'aprobacion', 'PuntajeCampaniaReprobacion' => 'reprobacion')
        );

        $select->join(
                array('us' => 'usuarios'), 'us.id = evaluaciones.id_supervisor', array('EvaluadorNombre' => 'nombre', 'EvaluadorApellido' => 'apellido')
        );
        
        $select->where(array("evaluaciones.id_agente"=>$idAgente));

        $select->order('id ASC');

        //$salida = $select->getSqlString();

        foreach ($this->tableGateway->selectWith($select) as $t) {
            $unaEvaluacion = new Evaluacion();
            $unaEvaluacion->setId($t["id"]);
            $unaEvaluacion->setCampania($t["Campania"]);
            $unaEvaluacion->setPuntajeCampania($this->getTotalPuntaje($t["CampaniaId"]));
            $unaEvaluacion->setFechaEvaluacion($t["fecha_evaluacion"]);
            $unaEvaluacion->setFechaLlamada($t["fecha_llamada"]);

            $unaEvaluacion->setPuntajeCampaniaAprobacion($t["PuntajeCampaniaAprobacion"]);
            $unaEvaluacion->setPuntajeCampaniaReprobacion($t["PuntajeCampaniaReprobacion"]);

            $unaEvaluacion->setEvaluador($t["EvaluadorNombre"] . " " . $t["EvaluadorApellido"]);

            $resultado = $this->getResultado($t["id"]);

            $unaEvaluacion->setPuntaje($resultado);

            $unaEvaluacion->setNotificado($t["notificado"]);
            $unaEvaluacion->setLeido($t["leido"]);
            $unaEvaluacion->id_campania = $t["id_campania"];
            $unaEvaluacion->id_agente = $t["id_agente"];

            $evaluaciones[] = $unaEvaluacion;
        }

        return $evaluaciones;
    }

    public function getResultado($id) {
        $total = 0;

        $sql = "SELECT SUM(puntaje) as total FROM puntaje WHERE id_evaluacion=$id";

        $adapter = Connect::getInstance()->getAdapter();

        $statement = $adapter->query(($sql));

        $result = $statement->execute();

        foreach ($result as $row) {
            $total = $row["total"];
        }

        return $total;
    }

    public function getTotalPuntaje($id) {

        $adapter = Connect::getInstance()->getAdapter();

        $sql = "SELECT SUM(t.puntaje) as total FROM topicos as t
                INNER JOIN topico_campania as tc on tc.id_topico = t.id
                WHERE tc.id_campania = $id";

        $statement = $adapter->query(($sql));

        $result = $statement->execute();

        $total = 0;

        foreach ($result as $row) {
            $total = $row["total"];
        }

        return $total;
    }

    public function getUltimmoMesEvaluacion() {//Chart
        $adapter = Connect::getInstance()->getAdapter();
        
        $sql = "SELECT Month(fecha_evaluacion) as mes,Year(fecha_evaluacion) as anio FROM `evaluaciones`
                GROUP BY Year(fecha_evaluacion) DESC ,Month(fecha_evaluacion) DESC
                LIMIT 1";
        
        $statement = $adapter->query($sql);

        $result = $statement->execute();

        $ultimo["mes"] = null;
        $ultimo["anio"] = null;

        foreach ($result as $row) {
            $ultimo["mes"] = $row["mes"];
            $ultimo["anio"] = $row["anio"];
        }
        
        return $this->getUltimos12($ultimo["mes"],$ultimo["anio"]);
    }
    
    public function getUltimos12($mes,$anio){
        $meses = array();
        
        $count = 0;
        
        for($i=$mes;$count<12;$i--){
            
            if($i<=0){
                $i=12;
                $anio = $anio-1;
            }
            
            $meses[] = array("mes" => $i, "anio" => $anio); 
            
            $count++;
        }
        
        return $meses;
    }
    
    public function getEvaluacionesChart(){
        $adapter = Connect::getInstance()->getAdapter();
        
        $sql = "SELECT COUNT(*) as total,Month(fecha_evaluacion) as mes,Year(fecha_evaluacion) as anio FROM evaluaciones
                GROUP BY Year(fecha_evaluacion) DESC ,Month(fecha_evaluacion) DESC";
        
        $statement = $adapter->query($sql);

        $result = $statement->execute();

        $res = array();
        
        foreach ($result as $row) {
            $res[] = array("mes"=>$row["mes"],"anio"=>$row["anio"],"total"=>$row["total"]);
        }
        
        return $res;
    }

    public function getUltimasEvaluaciones($tipo) {

        $res["fechaChart"] = $this->getUltimmoMesEvaluacion();
        $res["evaluacionesChart"] = $this->getEvaluacionesChart();
        return $res;
    }

    public function getMaxMinCategoria($valor = "MAX", $tipo = "all") {
        $adapter = Connect::getInstance()->getAdapter();

        $valor = ($valor == "MAX") ? "DESC" : "ASC";

        $sql = "SELECT c.id as idCategoria,c.nombre as nombreCategoria, t.id as idTopico, SUM(p.puntaje) as resultado  FROM categorias as c
                INNER JOIN topicos as t on c.id = t.id_categoria
                INNER JOIN puntaje as p on p.id_topico = t.id
                GROUP BY
                        idCategoria,idTopico
                ORDER BY resultado  $valor
                LIMIT 1";

        $statement = $adapter->query($sql);

        $result = $statement->execute();

        $categoria["nombre"] = null;
        $categoria["puntaje"] = null;

        foreach ($result as $row) {
            $categoria["nombre"] = $row["nombreCategoria"];
            $categoria["puntaje"] = $row["resultado"];
        }

        return $categoria;
    }

    public function getMaxMinTopico($valor = "MAX", $tipo = "all") {
        $adapter = Connect::getInstance()->getAdapter();

        $valor = ($valor == "MAX") ? "DESC" : "ASC";

        $sql = "SELECT
                t.nombre as nom,
                p.id_topico,
                SUM(p.puntaje) as puntajes                                         
             FROM
                puntaje as p                                        
             INNER JOIN
                topicos as t 
                       on t.id = p.id_topico                                        
             GROUP BY
                p.id_topico
             ORDER BY puntajes  $valor
             LIMIT 1";

        $statement = $adapter->query($sql);

        $result = $statement->execute();

        $topico["nombre"] = null;
        $topico["puntaje"] = null;

        foreach ($result as $row) {
            $topico["nombre"] = $row["nom"];
            $topico["puntaje"] = $row["puntajes"];
        }

        return $topico;
    }

    public function TotalAgentesPromedio($id = "all", $dateDesde = "", $dateHasta = "") {

        $where = "";

        if ($id != "all") {
            $where = "WHERE id_agente = '" . $id . "' ";
        }

        if ($dateDesde != "" && $dateHasta != "") {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }

            $where .= " fechaReg BETWEEN '" . $dateDesde . "' AND '" . $dateHasta . "'";
        }

        $adapter = Connect::getInstance()->getAdapter();
        $statement = $adapter->query("SELECT * FROM `evaluaciones` $where GROUP BY id_agente");

        $result = $statement->execute();

        $count = 0;

        foreach ($result as $row) {
            $count++;
        }

        return array("evaluados" => $count);
    }

    public function getAgentesEvaluaciones() {
        $evaluaciones = $this->obtenerTodos();

        $agentes = array();

        foreach ($evaluaciones["evaluaciones"] as $evaluacion) {
            if (!in_array($evaluacion->id_agente, $agentes)) {
                $agentes[] = $evaluacion->id_agente;
            }
        }

        $agentes_result = array();


        foreach ($agentes as $agente) {
            foreach ($evaluaciones["evaluaciones"] as $evaluacion) {
                if ($evaluacion->id_agente == $agente) {
                    $agentes_result["" . $agente . ""]["evaluaciones"][] = $evaluacion;
                }
            }
        }

        return $agentes_result;
    }

    public function AvgAgente($agente) {

        $porcentajes = 0;
        $totales = 0;
        $resultados = 0;

        if(is_array($agente)){
            $evaluaciones = $agente["evaluaciones"];
        }else{
            $evaluaciones = $agente->getEvaluaciones();
        }
        
        foreach ($evaluaciones as $evaluacion) {
            $evaluacion = $evaluacion;
            $id = $evaluacion->getId();
            $resultado = $this->getResultado($id);
            
            if($resultado){
                $idCampania = $evaluacion->id_campania;
                $total = $this->getTotalPuntaje($idCampania);
                $totales += $this->getTotalPuntaje($idCampania);
                $resultados += $resultado;
                //$porcentajes += $this->calcularPorcentaje($resultado, $total);
            }else{
                $porcentajes += 0;
                $totales += 0;
            }
        }

        $res = $this->calcularPorcentaje($resultados, $totales);

        return $res;
    }

    public function AvgAgentes() {

        $agentes = $this->getAgentesEvaluaciones();

        $count = 0;

        $avg = 0;

        foreach ($agentes as $agente) {
            $avg += $this->AvgAgente($agente);
            $count++;
        }

        $res = round($avg / $count, 2);

        return $res;
    }

    public function TopAgentes() {
        $evaluaciones = $this->obtenerTodos();

        $agentes = array();

        foreach ($evaluaciones["evaluaciones"] as $evaluacion) {
            if (!in_array($evaluacion->id_agente, $agentes)) {
                $agentes[] = $evaluacion->id_agente;
            }
        }

        $agentes_result = array();


        foreach ($agentes as $agente) {
            foreach ($evaluaciones["evaluaciones"] as $evaluacion) {
                if ($evaluacion->id_agente == $agente) {
                    $agentes_result["" . $agente . ""]["evaluaciones"][] = $evaluacion;
                }
            }
        }

        $top = array();

        foreach ($agentes_result as $agente) {
            foreach ($agente["evaluaciones"] as $evaluacion) {
                $evaluacion = $evaluacion;
                $id = $evaluacion->getId();
                $resultados[] = $this->getResultado($id);
                $idCampania = $evaluacion->id_campania;
                $total = $this->getTotalPuntaje($idCampania);
                $totales[] = $total;
            }
            $tot = 0;
            foreach ($totales as $t) {
                $tot+=$t;
            }
            $res = 0;
            foreach ($resultados as $r) {
                $res+=$r;
            }
            $unAgente = $agente["evaluaciones"]["0"]->getAgente();
            $unAgente = explode(" ", trim($unAgente));
            $top[] = array(
                "agente" => array(
                    "id" => $agente["evaluaciones"]["0"]->id_agente,
                    "nombre" => $unAgente[0],
                    "apellido" => $unAgente[1]
                ),
                "porcentaje" => $this->calcularPorcentaje($res, $tot)
            );
        }

        foreach ($top as $key => $row) {
            $agente[$key] = $row['agente'];
            $porcentaje[$key] = $row['porcentaje'];
        }

        array_multisort($porcentaje, SORT_DESC, $top);

        $res_top = array();

        for ($i = 0; $i < 5; $i++) {
            $res_top[] = $top[$i];
        }

        return $res_top;
    }

    public function calcularPorcentaje($puntaje, $total) {

        if ($puntaje > 0) {

            $porcentaje = $puntaje / ($total / 100);
        } else {
            $porcentaje = 0;
        }

        return $porcentaje;
    }

    public function TotalAgentesEvaluados($id = "all", $dateDesde = "", $dateHasta = "") {

        $where = "";

        if ($id != "all") {
            $where = "WHERE id_agente = '" . $id . "' ";
        }

        if ($dateDesde != "" && $dateHasta != "") {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }

            $where .= " fechaReg BETWEEN '" . $dateDesde . "' AND '" . $dateHasta . "'";
        }

        $adapter = Connect::getInstance()->getAdapter();
        $statement = $adapter->query("SELECT * FROM `evaluaciones` $where GROUP BY id_agente");

        $result = $statement->execute();

        $count = 0;

        foreach ($result as $row) {
            $count++;
        }

        return array("evaluados" => $count, "total" => $this->TotalAgentes());
    }

    public function TotalAgentes() {

        $adapter = Connect::getInstance()->getAdapter();
        $statement = $adapter->query("SELECT * FROM `usuarios` WHERE tipo=4");

        $result = $statement->execute();

        $count = 0;

        foreach ($result as $row) {
            $count++;
        }

        return $count;
    }

    public function DrawGraficaEvaluations($idAgente) {

        $where = "";

        if ($idAgente != "all") {
            $where = "WHERE e.id_agente = '" . $idAgente . "' ";
        }

        $aprobed = 0;
        $notAprobed = 0;
        $needWork = 0;

        $adapter = Connect::getInstance()->getAdapter();
        $statement = $adapter->query("  
            SELECT e.id,c.aprobacion,c.reprobacion,e.id_campania  
            FROM evaluaciones as e 
            INNER JOIN campanias as c on c.id = e.id_campania 
            $where
            GROUP BY e.id");

        $result = $statement->execute();

        $count = 0;

        $evas = array();

        foreach ($result as $row) {
            $evas[] = $row;
        }

        foreach ($evas as $row) {
            if ($row["id"] == "40") {
                $a = 0;
            }

            $resultado = $this->getResultado($row["id"]);
            $total = $this->getTotalPuntaje($row["id_campania"]);

            if ($resultado > 0) {
                $porcentaje = 100 - (($total - $resultado) * ($total / 100));
            } else {
                $porcentaje = 0;
            }


            if ($porcentaje >= $row["aprobacion"]) {
                $aprobed++;
            } elseif ($porcentaje >= $row["reprobacion"]) {
                $needWork++;
            } else {
                $notAprobed++;
            }
            $count++;
        }

        if ($aprobed > 0)
            $aprobed = round(($aprobed / $count) * 100);
        if ($needWork > 0)
            $needWork = round(($needWork / $count) * 100);
        if ($notAprobed > 0)
            $notAprobed = round(($notAprobed / $count) * 100);

        return array(
            "approbed" => $aprobed,
            "notApprobed" => $notAprobed,
            "needWork" => $needWork,
        );
    }

    public function obtenerPorId($id) {

        /**/
        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('u' => 'usuarios'), 'u.id = evaluaciones.id_agente', array('AgenteNombre' => 'nombre', 'AgenteApellido' => 'apellido')
        );

        $select->join(
                array('c' => 'campanias'), 'c.id = evaluaciones.id_campania', array('Campania' => 'nombre', 'PuntajeCampaniaAprobacion' => 'aprobacion', 'PuntajeCampaniaReprobacion' => 'reprobacion')
        );

        $select->join(
                array('us' => 'usuarios'), 'us.id = evaluaciones.id_supervisor', array('EvaluadorNombre' => 'nombre', 'EvaluadorApellido' => 'apellido')
        );

        $select->where(array("evaluaciones.id" => $id));
        /**/

        //$salida = $select->getSqlString();

        $rowset = $this->tableGateway->selectWith($select);

        $evaluacion = $rowset->current();

        $resultado = $this->getResultado($evaluacion["id"]);

        $unaEvaluacion = new Evaluacion(
                $evaluacion["id"], $evaluacion["Campania"], $evaluacion["id_campania"], ($evaluacion["AgenteNombre"] . " " . $evaluacion["AgenteNombre"]), $evaluacion["id_agente"], $evaluacion["archivo"], $evaluacion["fecha_llamada"], $evaluacion["fecha_evaluacion"], ($evaluacion["EvaluadorNombre"] . " " . $evaluacion["EvaluadorApellido"]), $evaluacion["id_supervisor"], $resultado, $evaluacion["notificado"], $evaluacion["comentarios"], $evaluacion["leido"], $evaluacion["PuntajeCampaniaAprobacion"], $evaluacion["PuntajeCampaniaReprobacion"]);

        return $unaEvaluacion;
    }

    public function buscarPorNombre($nombre) {
        
    }

    public function guardar($evaluacion) {

        $data = array(
            "id_campania" => $evaluacion->getCampania(),
            "fecha_evaluacion" => $evaluacion->getFechaEvaluacion(),
            "fecha_llamada" => $evaluacion->getFechaLlamada(),
            "id_agente" => $evaluacion->getAgente(),
            "id_supervisor" => $evaluacion->getEvaluador(),
            "archivo" => $evaluacion->getUrlAudio(),
            "id_supervisor" => $evaluacion->getEvaluador(),
            "notificado" => "0",
            "leido" => "0",
            "comentarios" => "",
        );

        if ($this->tableGateway->insert($data)) {
            $evaluacion->setId($this->tableGateway->lastInsertValue);
            return array("error" => "0", "evaluacion" => $evaluacion);
        }

        return array("error" => "1", "mensaje" => "Can't save Evaluation.");
    }

    public function update($evaluacion) {

        $data = array(
            "id_campania" => $evaluacion->getCampania(),
            "fecha_evaluacion" => $evaluacion->getFechaEvaluacion(),
            "fecha_llamada" => $evaluacion->getFechaLlamada(),
            "id_agente" => $evaluacion->getAgente(),
            "id_supervisor" => $evaluacion->getEvaluador(),
            "archivo" => $evaluacion->getUrlAudio(),
            "id_supervisor" => $evaluacion->getEvaluador(),
            "notificado" => "0",
            "leido" => "0",
            "comentarios" => "",
            "resultado" => $evaluacion->getPuntaje());

        if ($this->tableGateway->update($data, array("id" => $evaluacion->getId()))) {
            return array("error" => "0", "evaluacion" => $evaluacion);
        }

        return array("error" => "1", "mensaje" => "Can't update Topic.", "topico" => $evaluacion);
    }

    public static function delete($id) {
        $res = self::deltePuntajesEvaluacion($id);
        $sql = "DELETE FROM evaluaciones WHERE id = " . $id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
        return false;
    }

    public static function deltePuntajesEvaluacion($id) {
        $sql = "DELETE FROM puntaje WHERE id_evaluacion = " . $id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }
    
    

    // </editor-fold>
}