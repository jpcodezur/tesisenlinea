<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Campania;
use ArrayObject;
use Zend\Db\TableGateway\TableGateway;

class CampaniaDao extends BaseDao implements ICampaniaDao {

    private $listaCampanias;
    protected $tableGateway;

    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        $campanias = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();
        
        $select->join(
                array('od' => 'origenes_datos'), 'od.id = campanias.id_servidor', array('Servidor' => 'nombre'),'left'
        );

        $this->listaCampanias = $this->tableGateway->selectWith($select);

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->listaCampanias as $camp) {
            $uaCampania = new Campania();
            $uaCampania->setId($camp["id"]);
            $uaCampania->setNombre($camp["nombre"]);
            $uaCampania->setUbicacion($camp["ubicacion"]);
            $uaCampania->setAprobacion($camp["aprobacion"]);
            $uaCampania->setReprobacion($camp["reprobacion"]);
            $uaCampania->setUpdater($camp["updater"]);
            $uaCampania->setUpdated($camp["updated"]);
            $uaCampania->setFechaReg($camp["fechaReg"]);
            $uaCampania->setServidor($camp["Servidor"]);
            $campanias[] = $uaCampania;
        }

        return array("campanias" => $campanias, "paginator" => $paginator);
    }

    public static function save($campania) {
        $result = false;
        $connect = Connect::getInstance();
        $maxId = $connect->getMaxId("campanias");
        if (!Connect::getInstance()->exist("campanias", $campania->getNombre(),"nombre")) {
            $sql = "INSERT INTO campanias 
                (id,nombre,aprobacion,reprobacion,fechaReg,author,id_servidor) 
                VALUES('" . ($maxId + 1) . "','" .
                    $campania->getNombre() . "','" .
                    $campania->getAprobacion() . "','" .
                    $campania->getReprobacion() . "','" .
                    date("Y-m-d") . "','" .
                    "prueba" . "','".
                    $campania->getServidor() . "');\n";
            $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
            $result = $statement_campaign->execute()->getAffectedRows();

            if ($result) {
                foreach ($campania->getTopicos() as $topico) {
                    $sql = "INSERT INTO topico_campania(id_topico,id_campania) VALUES('" . $topico . "','" . ($maxId + 1) . "');\n";
                    $statement_topics = Connect::getInstance()->getAdapter()->query($sql);
                    $result = $statement_topics->execute()->getAffectedRows();
                    if ($result < 1)
                        return array("error"=>"1","mensaje"=>"Can't add Topic.");
                }
                return array("error"=>"0");
            }
        }else{
            $result = array("error"=>"1","mensaje"=>"Campaign already exist.");
        }

        return $result;
    }
    
    public static function update($campania) {
        $result = false;
        $connect = Connect::getInstance();
        if (Connect::getInstance()->exist("campanias", $campania->getId(),"id")) {
            $sql = "UPDATE campanias 
                SET nombre='" . $campania->getNombre() . "',
                 ubicacion='" . $campania->getUbicacion() . "',
                 aprobacion='" . $campania->getAprobacion() . "',
                 reprobacion='" . $campania->getReprobacion() . "',
                 id_servidor='" . $campania->getServidor() . "',
                 updated='" . date("Y-m-d") . "',
                 updater='" . "prueba" . "' 
                WHERE id=?";
            
            $statement_campaign = Connect::getInstance()->getAdapter()->query($sql,array($campania->getId()));
            //$result = $statement_campaign->execute();

            if ($statement_campaign) {
                $del = self::deleteTopicosCampania($campania->getId());
                
                    foreach ($campania->getTopicos() as $topico) {
                        $sql = "INSERT INTO topico_campania(id_topico,id_campania) VALUES('" . $topico . "','" . ($campania->getId()) . "');\n";
                        $statement_topics = Connect::getInstance()->getAdapter()->query($sql);
                        $result = $statement_topics->execute()->getAffectedRows();
                        if ($result < 1)
                            return array("error"=>"1","mensaje"=>"Can't add Topic.");
                    }
                
                return array("error"=>"0","campania"=>$campania);
            }
        }else{
            $result = array("error"=>"1","mensaje"=>"Campaign not exist.");
        }

        return $result;
    }
    
    public static function deleteTopicosCampania($id){
        $sql = "DELETE FROM topico_campania WHERE id_campania = ".$id;
        $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
        return $statement_campaign->execute()->getAffectedRows();
    }
    
    public static function getCampania($id){
        $campania = Connect::getInstance()->getObjectPorId($id,"campanias");
        
        $unaCampania = new Campania();
        $unaCampania->setId($campania["id"]);
        $unaCampania->setNombre($campania["nombre"]);
        $unaCampania->setAprobacion($campania["aprobacion"]);
        $unaCampania->setReprobacion($campania["reprobacion"]);
        $unaCampania->setUbicacion($campania["ubicacion"]);
        $unaCampania->setFechaReg($campania["fechaReg"]);
        $unaCampania->setServidor($campania["id_servidor"]);
        
        return $unaCampania;
        
    }
    
    public static function getCampaniaPorNombre($nombre){
        $campania = Connect::getInstance()->getObjectPorNombre($nombre,"campanias");
        
        $unaCampania = new Campania();
        $unaCampania->setId($campania["id"]);
        $unaCampania->setNombre($campania["nombre"]);
        $unaCampania->setAprobacion($campania["aprobacion"]);
        $unaCampania->setReprobacion($campania["reprobacion"]);
        $unaCampania->setUbicacion($campania["ubicacion"]);
        $unaCampania->setFechaReg($campania["fechaReg"]);
        $unaCampania->setServidor($campania["id_servidor"]);
        
        return $unaCampania;
        
    }
    
    public function getTopicos($id){
        $topicos = array();
        $adapter = Connect::getInstance()->getAdapter();
        $statement = $adapter->query("
            SELECT DISTINCT * FROM topicos 
            INNER JOIN topico_campania on topico_campania.id_topico = topicos.id
            WHERE topico_campania.id_campania=".$id); 
        $result = $statement->execute();
        foreach($result as $topico){
            $topicos[] = $topico["id"];
        }
        
        return $topicos;
    }
    
    public static function delete($id){
        $res = self::deleteTopicosCampania($id);
        $sql = "DELETE FROM campanias WHERE id = ".$id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }
    
    public function getAgents($id,$usuarioTableGateway){
        $agentes = array();
        
        $select = $usuarioTableGateway->getSql()->select();

        $select->join(
                array('tu' => 'tipos_usuario'), 'tu.id = usuarios.tipo', array('tipoUsuario' => 'usuario')
        );
        
        $select->join(
                array('ac' => 'agente_campania'), 'ac.id_agente = usuarios.id', array('idAgente' => 'id_agente')
        );
        
        $select->where(array('tipo' => '4','id_campania' => $id));
        
        $agentes_obj = $usuarioTableGateway->selectWith($select);
        
        foreach($agentes_obj as $agente){
            $agentes[$agente["id"]] = $agente["nombre"]." ".$agente["apellido"];
        }
        
        return $agentes;
        
    }
    
    public function getServerLocation($idCampania){
        /*
         * 1 Cloud
         * 2 Uruguay
         * 4 Republica dominicana
         * 
         */
        $campania = $this->getCampania($idCampania);
        $location = $campania->getServidor();
        
        if(trim(strtolower($location))=="4"){
            $location = "cloud";
        /*}elseif(trim(strtolower($location))=="1"){
            $location = "cloud";*/
        }else{
            $location = "uruguay";
        }
        
        return $location;
    }

}
