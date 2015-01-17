<?php

namespace Usuarios\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Evaluacion\EvaluacionAdd;
use Usuarios\Form\Evaluacion\EvaluacionAdd2;
use Usuarios\Form\Evaluacion\EvaluacionEdit;
use Usuarios\Form\Evaluacion\EvaluacionValidator;
use Usuarios\Model\Entity\Evaluacion;
use Usuarios\Model\Entity\Mensaje;
use Usuarios\Model\Entity\Puntaje;
use Usuarios\MisClases\CallFinder;
use Usuarios\MisClases\SendEmail;

class EvaluacionController extends AbstractActionController {

    private $evaluacionDao;
    private $campaniaDao;
    private $categoriaDao;
    private $puntajeDao;
    private $tableGateway;
    private $usuarioDao;
    private $alertaDao;
    private $mensajeDao;

    public function setEvaluacionDao($dao) {
        $this->evaluacionDao = $dao;
    }

    public function setAlertaDao($dao) {
        $this->alertaDao = $dao;
    }
    
    public function setMensajeDao($dao) {
        $this->mensajeDao = $dao;
    }
    
    public function setUsuarioDao($dao) {
        $this->usuarioDao = $dao;
    }

    public function setCampaniaDao($dao) {
        $this->campaniaDao = $dao;
    }

    public function setCategoriaDao($dao) {
        $this->categoriaDao = $dao;
    }

    public function setTopicoDao($dao) {
        $this->topicoDao = $dao;
    }

    public function setPuntajeDao($dao) {
        $this->puntajeDao = $dao;
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function listAction() {
        $result = $this->evaluacionDao->obtenerTodos();
        $paginator = $result["paginator"];
        $paginator->setCurrentPageNumber((int) $this->getEvent()->getRouteMatch()->getParam('id', 1));
        return new ViewModel(array("evaluaciones" => $result["evaluaciones"], "paginator" => $paginator));
    }

    public function mylistAction() {
        if (isset($_SESSION["miSession"]["usuario"])) {
            $id = $_SESSION["miSession"]["usuario"]->getId();
            $result = $this->usuarioDao->obtenerEvaluacionesUsuario($id, $this->tableGateway);
            $paginator = $result["paginator"];
            $paginator->setCurrentPageNumber((int) $this->getEvent()->getRouteMatch()->getParam('id', 1));
            return new ViewModel(array("evaluaciones" => $result["evaluaciones"], "paginator" => $paginator));
        }
    }

    public function addAction() {

        $form = new EvaluacionAdd($this->tableGateway, $this->campaniaDao);

        $params = $this->getEvent()->getRouteMatch()->getParams();

        $save = false;

        if (isset($params["save"])) {
            $save = (bool) $params["save"];
        }

        return new ViewModel(array("form" => $form, "save" => $save));
    }

    public function add2Action() {

        $fecha = $_POST["fecha-llamada"];

        $idCampania = $this->getRequest()->getPost('campania-evaluacion');

        $idAgente = $this->getRequest()->getPost('agentes-evaluacion');

        $agente = $this->usuarioDao->getUsuario($idAgente);

        $idAgenteServidor = $agente->getIdCallCenter();

        $servidor = $this->campaniaDao->getServerLocation($idCampania);

        $table = CallFinder::getInstance($fecha, $fecha, $idAgenteServidor, $servidor)->run();

        $form = new EvaluacionAdd($this->tableGateway, $this->campaniaDao);

        $idCampania = $this->getRequest()->getPost('campania-evaluacion');
        $idAgente = $this->getRequest()->getPost('agentes-evaluacion');
        $audioAgente = $this->getRequest()->getPost('audio-agent-evaluacion');
        $fechaLlamada = $this->getRequest()->getPost('fecha-llamada');
        $fechaEvaluacion = $this->getRequest()->getPost('fecha-evaluacion');
        $idEvaluador = $this->getRequest()->getPost('id-evaluador-evaluacion');

        return new ViewModel(array(
            "form" => $form,
            "table" => $table,
            "idCampania" => $idCampania,
            "idAgente" => $idAgente,
            "audioAgente" => $audioAgente,
            "fechaLlamada" => $fechaLlamada,
            "fechaEvaluacion" => $fechaEvaluacion,
            "idEvaluador" => $idEvaluador,
            "save" => false));
    }

    public function add3Action() {

        $form = new EvaluacionAdd2($this->tableGateway, $this->campaniaDao);

        $data = $this->request->getPost();

        $form->setData($data);

        $valid = $form->isValid();

        if ($valid) {

            $total = 0;

            if (isset($_POST["puntaje"])) {
                foreach ($_POST["puntaje"] as $p) {
                    $total += $p;
                }
            }

            $evaluacion = new Evaluacion();
            $evaluacion->setCampania($this->getRequest()->getPost('campania-evaluacion', null));
            $evaluacion->setAgente($this->getRequest()->getPost('agentes-evaluacion', null));
            $evaluacion->setUrlAudio($this->getRequest()->getPost('audio-agent-evaluacion', null));
            $evaluacion->setFechaLlamada($this->getRequest()->getPost('fecha-llamada', null));
            $evaluacion->setFechaEvaluacion($this->getRequest()->getPost('fecha-evaluacion', null));
            $evaluacion->setEvaluador($this->getRequest()->getPost('id-evaluador-evaluacion', null));

            $idCampania = $evaluacion->getCampania();

            $c = $this->campaniaDao->getCampania($idCampania);

            $evaluacion->setPuntajeCampaniaAprobacion($c->getAprobacion());
            $evaluacion->setPuntajeCampaniaReprobacion($c->getReprobacion());
            $evaluacion->setPuntaje($total);

            $res = $this->topicoDao->obtenerTopicosCampania($evaluacion->getCampania());

            $res["evaluacion"] = $evaluacion;

            return new ViewModel(array(
                "form" => $form,
                "topicos" => $res["topicos"],
                "evaluacion" => $res["evaluacion"],
                "save" => false));
        }

        return new ViewModel(array("form" => $form, "save" => false));
    }

    public function add4Action() {

        $form = new EvaluacionAdd2($this->tableGateway, $this->campaniaDao);

        $data = $this->request->getPost();

        $form->setData($data);

        $valid = $form->isValid();

        if ($valid) {

            $total = 0;

            if (isset($_POST["puntaje"])) {
                foreach ($_POST["puntaje"] as $p) {
                    $total += $p;
                }
            }

            $evaluacion = new Evaluacion();
            $evaluacion->setCampania($this->getRequest()->getPost('campania-evaluacion', null));
            $evaluacion->setAgente($this->getRequest()->getPost('agentes-evaluacion', null));
            $evaluacion->setUrlAudio($this->getRequest()->getPost('audio-agent-evaluacion', null));
            $evaluacion->setFechaLlamada($this->getRequest()->getPost('fecha-llamada', null));
            $evaluacion->setFechaEvaluacion($this->getRequest()->getPost('fecha-evaluacion', null));
            $evaluacion->setEvaluador($this->getRequest()->getPost('id-evaluador-evaluacion', null));

            $idCampania = $evaluacion->getCampania();

            $c = $this->campaniaDao->getCampania($idCampania);

            $evaluacion->setPuntajeCampaniaAprobacion($c->getAprobacion());
            $evaluacion->setPuntajeCampaniaReprobacion($c->getReprobacion());
            $evaluacion->setPuntaje($total);

            $res = $this->topicoDao->obtenerTopicosCampania($evaluacion->getCampania());

            $res["evaluacion"] = $evaluacion;

            $accion = $this->getRequest()->getPost('accion-evaluacion', null);

            if ($accion == "guardar") {
                
                /* Alerts */
                $urlaudio = $this->getRequest()->getPost('url-audio-agent-evaluacion', null);
                $audio = $this->getRequest()->getPost('audio-agent-evaluacion', null);
                $notify = $this->getRequest()->getPost('switch-field-notify', null);
                $sendEmail = $this->getRequest()->getPost('switch-field-send-email', null);

                $body = $this->getRequest()->getPost('textarea', null);

                $to = $this->usuarioDao->getUsuario($evaluacion->getAgente())->getEmail();

                $asunto = "New Evaluation!";
                
                if ($sendEmail == "on") {
                    
                    $unEmail = new SendEmail($to, "support@telecomnetworks.net", $asunto);
                    $unEmail->sendEmail($body);
                    
                    if(isset($_SESSION["miSession"]["usuario"])){
                    
                        $idEmisor = $_SESSION["miSession"]["usuario"]->getId();

                        $unMensaje = new Mensaje();
                        
                        $unMensaje->setIdEmisor($idEmisor);
                        $unMensaje->setIdReceptor($evaluacion->getAgente());
                        $unMensaje->setMensaje($body);
                        $unMensaje->setAsunto($asunto);
                        $unMensaje->setFechaCreado(date("Y-m-d"));
                        $unMensaje->setEstado("1");
                        
                        $this->mensajeDao->guardar($unMensaje);
                    
                    }
                }

                if($notify=="on"){
                    $this->alertaDao->guardar($evaluacion->getAgente(),$body,"1",$urlaudio,$audio,$asunto);
                }
                /* Fin Alerts */

                $evaluacion_result = $this->evaluacionDao->guardar($evaluacion);

                if ($evaluacion_result["error"] == "0") {

                    $_POST["puntaje"] = json_decode($_POST["puntajes-evaluacion"]);

                    foreach ($_POST["puntaje"] as $key => $value) {
                        $unPuntaje = new Puntaje();
                        $unPuntaje->setId(null);
                        $unPuntaje->setIdEvaluacion($evaluacion_result["evaluacion"]->getId());
                        $unPuntaje->setIdTopico($key);
                        $unPuntaje->setPuntaje($value);
                        if (isset($_POST["comentarios"][$key]))
                            $unPuntaje->setComentarios($_POST["comentarios"][$key]);
                        else
                            $unPuntaje->setComentarios("");

                        $result_puntaje = $this->puntajeDao->guardar($unPuntaje);

                        if (!$result_puntaje) {
                            return new ViewModel(array("form" => $form, "topicos" => $res["topicos"], "evaluacion" => $res["evaluacion"], "save" => false));
                        }
                    }
                    //return new ViewModel(array("form" => $form, "topicos" => $res["topicos"], "evaluacion" => $res["evaluacion"], "save" => true));
                    return $this->forward()->dispatch('usuarios/controller/evaluacion', array(
                                'action' => 'add',
                                'save' => 'true'
                    ));
                }
            }

            return new ViewModel(array("form" => $form, "puntajes" => $_POST["puntaje"], "evaluacion" => $res["evaluacion"], "save" => false));
        }

        return new ViewModel(array("form" => $form, "save" => false));
    }

    public function editAction() {

        $id = $this->request->getQuery('id');

        $params = $this->getEvent()->getRouteMatch()->getParams();

        $save = false;

        if (isset($params["save"])) {
            $save = (bool) $params["save"];
        }

        if (!$id) {
            $id = $this->getRequest()->getPost('id-evaluacion', null);
        }

        $evaluacion = $this->evaluacionDao->obtenerPorId($id);

        $form = new EvaluacionEdit($evaluacion);

        if ($id) {

            if ($this->request->isPost()) {

                $validator = new EvaluacionValidator();

                $accion = $this->getRequest()->getPost('accion-evaluacion', null);

                //if ($form->isValid()) {

                if ($accion == "guardar") {

                    $form->setInputFilter($validator);
                    $data = $this->request->getPost();
                    $form->setData($data);
                }

                //}
            }
        }
        return new ViewModel(array("form" => $form, "save" => $save, "evaluacion" => $evaluacion));
    }

    public function edit2Action() {
        
    }

    public function edit3Action() {

        //$id_campania = $this->getRequest()->getPost('campania-evaluacion', null);
        $id = $this->getRequest()->getPost('id-evaluacion', null);

        //$evaluacion = $this->evaluacionDao->obtenerPorId($id);
        $evaluacion = new Evaluacion();

        $evaluacion->setId($this->getRequest()->getPost('id-evaluacion', null));
        $evaluacion->setCampania($this->getRequest()->getPost('campania-evaluacion', null));
        $evaluacion->setAgente($this->getRequest()->getPost('agentes-evaluacion', null));
        $evaluacion->setUrlAudio($this->getRequest()->getPost('audio-agent-evaluacion', null));
        $evaluacion->setFechaLlamada($this->getRequest()->getPost('fecha-evaluacion', null));
        $evaluacion->setFechaEvaluacion($this->getRequest()->getPost('fecha-llamada', null));
        $evaluacion->setEvaluador($this->getRequest()->getPost('id-evaluacion', null));
        $evaluacion->setPuntajeCampaniaAprobacion($this->getRequest()->getPost('campania-evaluacion-aprobacion', null));
        $evaluacion->setPuntajeCampaniaReprobacion($this->getRequest()->getPost('campania-evaluacion-reprobacion', null));

        $form = new EvaluacionEdit($evaluacion);

        $data = $this->request->getPost();

        $form->setData($data);

        $valid = $form->isValid();

        if ($valid) {

            $total = 0;

            if (isset($_POST["puntaje"])) {
                foreach ($_POST["puntaje"] as $p) {
                    $total += $p;
                }
            }

            $evaluacion->setPuntaje($total);

            $res = $this->topicoDao->obtenerTopicosEvaluacion($id);

//            foreach($res["topicos"] as $topico){
//                $topico->resultado = $this->puntajeDao->obtenerPuntajeTopico($topico->getId());
//            }

            $res["evaluacion"] = $evaluacion;

            $accion = $this->getRequest()->getPost('accion-evaluacion', null);

            if ($accion == "guardar") {

                $evaluacion_result = $this->evaluacionDao->update($evaluacion);

                if ($evaluacion_result["error"] == "0") {

                    foreach ($_POST["puntaje"] as $key => $value) {
                        $unPuntaje = new Puntaje();
                        $unPuntaje->setId(null);
                        $unPuntaje->setIdEvaluacion($evaluacion_result["evaluacion"]->getId());
                        $unPuntaje->setIdTopico($key);
                        $unPuntaje->setPuntaje($value);
                        if (isset($_POST["comentarios"][$key]))
                            $unPuntaje->setComentarios($_POST["comentarios"][$key]);
                        else
                            $unPuntaje->setComentarios("");

                        $result_puntaje = $this->puntajeDao->update($unPuntaje);

//                        if ($result_puntaje["error"] == "1") {
//                            return new ViewModel(array("form" => $form, "topicos" => $res["topicos"], "evaluacion" => $res["evaluacion"], "save" => false));
//                        }
                    }

                    //return new ViewModel(array("form" => $form, "topicos" => $res["topicos"], "evaluacion" => $res["evaluacion"], "save" => true));
                    return $this->forward()->dispatch('usuarios/controller/evaluacion', array(
                                'action' => 'edit',
                                'save' => 'true',
                                'form' => $form,
                                'evaluacion' => $evaluacion,
                                'id' => $evaluacion->getId()
                    ));
                }
            }

            return new ViewModel(array("form" => $form, "topicos" => $res["topicos"], "evaluacion" => $res["evaluacion"], "save" => false));
        }

        return new ViewModel(array("form" => $form, "save" => false));
    }

    public function deleteAction() {
        if ($this->request->isGet()) {

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', null);

            if ($id) {
                $result = $this->evaluacionDao->delete($id);
            }

            if ($result) {
                return $this->redirect()->toRoute('usuarios', array(
                            'controller' => 'evaluacion',
                            'action' => 'list',
                            'id' => '1'
                ));
            }
        }
    }

    public function getRecordAction() {

        $calldate = $this->request->getQuery('calldate');
        $idcampania = $this->request->getQuery('idCampania');
        $agente = $this->request->getQuery('agente');
        $campania = $this->request->getQuery('campania');
        $filename = $this->request->getQuery('filename');
        $unaCampania = $this->campaniaDao->getCampania($idcampania);
        $campaniaNombre = $unaCampania->getNombre();

        $servidor = $unaCampania->getServidor();
        switch ($servidor) {
            case "1":
                $servidor = "cloud";
                break;
            case "2":
                $servidor = "uruguay";
                break;
            case "4":
                $servidor = "cloud";
                break;
        }


        $this->getRecord($calldate, $campania, $agente, $filename, $servidor);
        $file = $this->getBaseUrl() . "records" . DIRECTORY_SEPARATOR;

        $fecha = $calldate;
        $fecha = explode(" ", trim($fecha));
        $hora = str_replace(":", "-", $fecha[1]);
        $fecha = $fecha[0];

        $agente = str_replace(" ", "-", ($agente));
        $campania = str_replace(" ", "-", ($campania));

        $filename = "/records/" . $agente . "_" . $campania . "_" . $fecha . "_" . $hora . ".mp3";

        $uri = $this->getRequest()->getUri();
        $scheme = explode("/", $uri->getPath());

        $base = $scheme[1];

        $html = '<script>audiojs.events.ready(function() {audiojs.createAll();});</script>';
        $html .= '<audio id="record-audio" src="/' . $base . '/public' . $filename . '" preload="auto"></audio>';

        $view = new JsonModel(array("html" => $html));

        $view->setTerminal(true);

        return $view;
    }

    public function getRecord($calldate, $campania, $agente, $filename, $servidor) {
        $fecha = $calldate;

        $rutaFilename = $filename;

        $fecha = explode(" ", trim($fecha));

        $hora = str_replace(":", "-", $fecha[1]);

        $fecha = $fecha[0];

        $agente = str_replace(" ", "-", ($agente));

        $campania = str_replace(" ", "-", ($campania));

        $file = $this->getBaseUrl(false) . "records" . "/";

        $filename = $file . $agente . "_" . $campania . "_" . $fecha . "_" . $hora . ".mp3";

        $res = false;

        $filename = $_SERVER["DOCUMENT_ROOT"] . $filename;

        if (!is_file($filename)) {

            $string = file_get_contents("http://sitios.telecomnetworks.net/callfinder/download.php?get=" . $rutaFilename . "&source=$servidor");

            $dirname = dirname($filename);

            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }

            $fh = fopen($filename, "a") or die("Could not open log file.");

            $res = fwrite($fh, "$string") or die("Could not write file!");

            fclose($fh);
        }
    }

    public function getBaseUrl($servername = true) {
        $url = $_SERVER['REQUEST_URI']; //returns the current URL
        $parts = explode('/', $url);
        if ($servername)
            $dir = $_SERVER['SERVER_NAME'];
        else
            $dir = "";
        for ($i = 0; $i < count($parts) - 1; $i++) {
            $dir .= $parts[$i] . "/";
            if ($parts[$i] == "public")
                break;
        }
        return $dir;
    }

}