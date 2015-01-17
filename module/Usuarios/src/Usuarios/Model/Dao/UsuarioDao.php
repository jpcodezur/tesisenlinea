<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Usuario;
use ArrayObject;
use Zend\Db\TableGateway\TableGateway;
use Usuarios\Model\Connect;
use Usuarios\Model\Entity\Evaluacion;

class UsuarioDao implements IUsuarioDao {

    private $listaUsuario;
    protected $tableGateway;
    private $adapter;

    public function __construct($tableGateway = null, $adapter = null) {
        $this->tableGateway = $tableGateway;
        $this->adapter = $adapter;
    }

    public function obtenerTodos() {

        $usuarios = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(
                array('tu' => 'tipos_usuario'), 'tu.id = usuarios.tipo', array('tipoUsuario' => 'usuario')
        );

        $select->order('id ASC');

        //$salida = $select->getSqlString();

        $this->listaUsuario = $this->tableGateway->selectWith($select);

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->listaUsuario as $usr) {
            $unUsuario = new Usuario();
            $unUsuario->setNombre($usr["nombre"]);
            $unUsuario->setEmail($usr["email"]);
            $unUsuario->setApellido($usr["apellido"]);
            $unUsuario->setTipo($usr["tipoUsuario"]);
            $unUsuario->setId($usr["id"]);
            $unUsuario->setAvatar($usr["avatar"]);
            $usuarios[] = $unUsuario;
        }

        return array("usuarios" => $usuarios, "paginator" => $paginator);
    }
    
    public function obtenerTodosReportes($evaluacionDao,$usuarioActual=null,$fechaDesde=null,$fechaHasta=null,$agentes=null,$campanias=null) {

        $usuarios = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->join(array('tu' => 'tipos_usuario'), 'tu.id = usuarios.tipo', array('tipoUsuario' => 'usuario'));
        
        $select->join(array('e' => 'evaluaciones'), 'e.id_agente = usuarios.id', array('rArchivo' => 'archivo'));
        
        $selectMiId = $this->tableGateway->getSql()->select();
        $selectMiId->columns(array('id'));
        $selectMiId->where(array("usuarios.id"=>$usuarioActual->getId()));

        if($usuarioActual){
            $select->where->notIn("usuarios.id",$selectMiId);
        }
        
        if($agentes){
            $select->where->in("usuarios.id",array($agentes));
        }
        
        if($fechaDesde){
            $select->where->between("e.fecha_evaluacion",$fechaDesde,$fechaHasta);
        }
        
        $select->group('usuarios.id');
        
        $select->order('usuarios.id ASC');
        
        //$salida = $select->getSqlString();

        $this->listaUsuario = $this->tableGateway->selectWith($select);

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->listaUsuario as $usr) {
            $unUsuario = new Usuario();
            $unUsuario->setId($usr["id"]);
            
            $idUsuario = $unUsuario->getId();
            
            $evaluaciones = $evaluacionDao->getEvaluacionesAgente($idUsuario);
            $unUsuario->setEvaluaciones($evaluaciones);
            $unUsuario->setPorcentaje($evaluacionDao->AvgAgente($unUsuario));
            $unUsuario->setNombre($usr["nombre"]);
            $unUsuario->setEmail($usr["email"]);
            $unUsuario->setApellido($usr["apellido"]);
            $unUsuario->setTipo($usr["tipoUsuario"]);
            $unUsuario->setId($usr["id"]);
            $unUsuario->setAvatar($usr["avatar"]);
            $usuarios[] = $unUsuario;
        }

        return array("usuarios" => $usuarios, "paginator" => $paginator);
    }
    
    public function getUsuarioLikeNombre($nombre){
        $usuarios = array();
        
        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();
        
        $where = new \Zend\Db\Sql\Where();

        $where->literal('nombre LIKE ? OR apellido LIKE ? OR email LIKE ?', array('%' . $nombre . '%','%' . $nombre . '%','%' . $nombre . '%'));

        $select->where($where);
        
        $select->order('id ASC');
        
        $usuarios = $this->tableGateway->selectWith($select);
        
        $usuarios_result = array();
        
        foreach($usuarios as $usuario){
            $usuarios_result[] = $usuario;
        }
        
        return json_encode($usuarios_result);
    }

    public static function getUsuario($id) {

        $usuario = Connect::getInstance()->getObjectPorId($id, "usuarios");

        if ($usuario) {

            $unUsuario = new Usuario();
            $unUsuario->setNombre($usuario["nombre"]);
            $unUsuario->setApellido($usuario["apellido"]);
            $unUsuario->setEmail($usuario["email"]);
            $unUsuario->setTipo($usuario["tipo"]);
            $unUsuario->setId($usuario["id"]);
            $unUsuario->setIdCallCenter($usuario["id_callcenter"]);
            if (isset($usuario["avatar"]))
                $unUsuario->setAvatar($usuario["avatar"]);

            return $unUsuario;
        }
        return false;
    }

    public function obtenerPorId($id) {

        $usuario = false;

        if ($id) {
            $id = (int) $id;

            $usuario = $rowset->current();

            $row = $rowset->current();
            if (!$row) {
                
            } else {
                $unUsuario = new Usuario();
                $unUsuario->setNombre($usuario["nombre"]);
                $unUsuario->setApellido($usuario["apellido"]);
                $unUsuario->setEmail($usuario["email"]);
                $unUsuario->setTipo($usuario["tipo"]);
                $unUsuario->setId($usuario["id"]);
                if (isset($usuario["avatar"]))
                    $unUsuario->setAvatar($usuario["avatar"]);
                $usuario = $unUsuario;
            }
        }
        return $usuario;
    }

    public function getUserByEmail($email) {

        $select = $this->tableGateway->getSql()->select();

        $select->where(array("email" => $email));

        $usuarios =  $this->tableGateway->selectWith($select);
        
        $usu = null;
        
        foreach($usuarios as $usu){
            $usu = $usu;
        }

        return $usu["id"];
    }
    
    public function obtenerEvaluacionesUsuario($id, $table) {

        $evaluaciones = array();

        $sql = $table->getSql();

        $select = $table->getSql()->select();

        $select->join(
                array('u' => 'usuarios'), 'u.id = evaluaciones.id_agente', array('AgenteNombre' => 'nombre', 'AgenteApellido' => 'apellido')
        );

        $select->join(
                array('c' => 'campanias'), 'c.id = evaluaciones.id_campania', array('Campania' => 'nombre', 'PuntajeCampaniaAprobacion' => 'aprobacion', 'PuntajeCampaniaReprobacion' => 'reprobacion')
        );

        $select->join(
                array('us' => 'usuarios'), 'us.id = evaluaciones.id_supervisor', array('EvaluadorNombre' => 'nombre', 'EvaluadorApellido' => 'apellido')
        );

        $select->where(array("u.id" => $id));

        $select->order('id ASC');

        //$salida = $select->getSqlString();

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);

        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($table->selectWith($select) as $t) {
            $unaEvaluacion = new Evaluacion();
            $unaEvaluacion->setId($t["id"]);
            $unaEvaluacion->setFechaEvaluacion($t["fecha_evaluacion"]);
            $unaEvaluacion->setFechaLlamada($t["fecha_llamada"]);

            $unaEvaluacion->setPuntajeCampaniaAprobacion($t["PuntajeCampaniaAprobacion"]);
            $unaEvaluacion->setPuntajeCampaniaReprobacion($t["PuntajeCampaniaReprobacion"]);

            $unaEvaluacion->setAgente($t["AgenteNombre"] . " " . $t["AgenteApellido"]);
            $unaEvaluacion->setCampania($t["Campania"]);
            $unaEvaluacion->setEvaluador($t["EvaluadorNombre"] . " " . $t["EvaluadorApellido"]);

            $unaEvaluacion->setPuntaje($t["resultado"]);

            $unaEvaluacion->setNotificado($t["notificado"]);
            $unaEvaluacion->setLeido($t["leido"]);

            $evaluaciones[] = $unaEvaluacion;
        }

        return array("evaluaciones" => $evaluaciones, "paginator" => $paginator);
    }

    public function buscarPorNombre($nombre) {
        $usuariosEncontrados = new ArrayObject();
        foreach ($this->listaUsuario as $usuario) {
            if ($usuario->getNombre() == $nombre) {
                $usuariosEncontrados->append($usuario);
            }
        }
        return $usuariosEncontrados;
    }

    public function buscarPorEmail($email) {
        $usuariosEncontrados = new ArrayObject();
        foreach ($this->listaUsuario as $usuario) {
            if ($usuario->getEmail() == $email) {
                $usuariosEncontrados->append($usuario);
            }
        }
        return $usuariosEncontrados;
    }

    public function obtenerCuenta($email, $clave) {
        $clave = md5($clave);

        $select = $this->tableGateway->getSql()->select();

        $select->where(array("email" => $email, "md5" => $clave));

        $rowset = $this->tableGateway->selectWith($select);

        $usuario = $rowset->current();

        if ($usuario) {

            $unUsuario = new Usuario();
            $unUsuario->setNombre($usuario["nombre"]);
            $unUsuario->setApellido($usuario["apellido"]);
            $unUsuario->setEmail($usuario["email"]);
            $unUsuario->setTipo($usuario["tipo"]);
            $unUsuario->setId($usuario["id"]);
            if (isset($usuario["avatar"]))
                $unUsuario->setAvatar($usuario["avatar"]);
            $usuario = $unUsuario;
        }
        return $usuario;
    }

    public function getTipos() {
        $tipos = array("" => "SELECCIONAR");

        $sql = "SELECT * FROM tipos_usuario";

        $statement = $this->adapter->query($sql);
        $salida = $statement->execute();
        foreach ($salida as $s) {
            $tipos[$s["id"]] = $s["usuario"];
        }
        return $tipos;
    }

    public function getCampanias() {
        $campanias = array();

        $sql = "SELECT * FROM campanias";

        $statement = $this->adapter->query($sql);
        $salida = $statement->execute();
        foreach ($salida as $s) {
            $campanias[$s["id"]] = $s["nombre"];
        }

        return $campanias;
    }

    public function getSelectedCampanias($id_user) {

        $campanias = array();
        if ($id_user != "") {
            $sql = "SELECT * FROM campanias 
                    INNER JOIN agente_campania on agente_campania.id_campania = campanias.id 
                    WHERE agente_campania.id_agente = " . $id_user;

            $statement = $this->adapter->query($sql);
            $salida = $statement->execute();
            foreach ($salida as $s) {
                $campanias[] = $s["id"];
            }
        }

        return $campanias;
    }

    public function guardar($usuario) {

        $data = array(
            "id" => $usuario->getId(),
            "email" => $usuario->getEmail(),
            "nombre" => $usuario->getNombre(),
            "apellido" => $usuario->getApellido(),
            "md5" => md5($usuario->getClave()),
            "tipo" => $usuario->getTipo(),
            "id_callcenter" => $usuario->getIdCallcenter(),
            "fechaReg" => date("Y-m-d"),
            "estado" => "1",
        );

        $avatar = $usuario->getAvatar();

        $campanias = $usuario->getCampanias();

        $result = $this->tableGateway->insert($data);

        $last_id = $this->tableGateway->lastInsertValue; //getting last inserted id

        /*
         * Insert el avatar del usuario si existe 
         * Nota-1: Esto esta mal el avatar deberia estar en la misma tabla del usuario
         * En un futuro se deberia refactorizar el codigo y eliminar la tabla usuario_avatar
         */

        if ($result && $avatar) {
            $adapter = $this->tableGateway->getAdapter();
            $userAvatar = new TableGateway('usuario', $adapter); //this will insert in hobbies table.

            $data_arr = array(
                'id' => $last_id,
                "avatar" => $usuario->getAvatar(),
            );

            $result = $userAvatar->insert($data_arr);
        }

        //Insert de campanias

        if ($result && count($campanias) > 0) {

            $adapter = $this->tableGateway->getAdapter();
            $userCampania = new TableGateway('agente_campania', $adapter); //this will insert in hobbies table.

            foreach ($campanias as $campania) {

                $data_arr = array(
                    'id_agente' => $last_id,
                    "id_campania" => $campania,
                );

                $result = $userCampania->insert($data_arr);
            }
        }

        return $result;
    }

    public function update($user) {
        $result = false;

        $campanias = $user->getCampanias();

        $data = array(
            "nombre" => $user->getNombre(),
            "apellido" => $user->getApellido(),
            "email" => $user->getEmail(),
            "tipo" => $user->getTipo(),
            "id_callcenter" => $user->getIdCallcenter(),
        );

        if ($user->getAvatar()) {
            $data["avatar"] = $user->getAvatar();
        }

        $this->tableGateway->update($data, array("id" => $user->getId()));

        $user = $this->getUsuario($user->getId());

        $user->setCampanias($campanias);

        $this->deleteCampaniasUsuario($user->getId());

        if (count($user->getCampanias()) > 0) {
            foreach ($user->getCampanias() as $campania) {
                $sql = "INSERT INTO agente_campania(id_agente,id_campania) VALUES('" . $user->getId() . "','" . $campania . "');\n";
                $statement_topics = Connect::getInstance()->getAdapter()->query($sql);
                $result = $statement_topics->execute()->getAffectedRows();
                if ($result < 1) {
                    return array("error" => "1", "mensaje" => "Can't add Campaign.");
                }
            }
        }

        return array("error" => "0", "usuario" => $user);
    }

    public static function delete($id) {
        $resC = self::deleteCampaniasUsuario($id);
        $resE = self::deleteEvaluacionesUsuario($id);
        $resA = self::deleteAlertasUsuario($id);
        $sql = "DELETE FROM usuarios WHERE id = " . $id;
        $res = Connect::getInstance()->getAdapter()->query($sql);
        return $res->execute()->getAffectedRows();
    }

    public static function deleteAvatarUsuario($id) {
        $sql = "DELETE FROM usuario_avatar WHERE id_user = " . $id;
        $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
        return $statement_campaign->execute()->getAffectedRows();
    }

    public static function deleteCampaniasUsuario($id) {
        $sql = "DELETE FROM agente_campania WHERE id_agente = " . $id;
        $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
        return $statement_campaign->execute()->getAffectedRows();
    }

    public static function deleteAlertasUsuario($id) {
        $sql = "DELETE FROM alertas WHERE id_agente = " . $id;
        $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
        return $statement_campaign->execute()->getAffectedRows();
    }

    public static function deleteEvaluacionesUsuario($id) {
        $sql = "DELETE FROM evaluaciones WHERE id_agente = " . $id;
        $statement_campaign = Connect::getInstance()->getAdapter()->query($sql);
        return $statement_campaign->execute()->getAffectedRows();
    }

}
