<?php

namespace Usuarios\Controller\Inputs;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Usuarios\Model\Dao\InputDao;
use Usuarios\Model\Entity\Input;

class InputController extends AbstractActionController {

    private $dao;

    public function __construct() {
        
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function setDao($dao){
        $this->dao = new InputDao($dao);
    }

    public function IndexAction() {
        die("500");
    }

    public function ListAction() {
        $response = new \Usuarios\MisClases\Respuesta();
        $resp_temp = $this->params()->fromRoute('response');

        if ($resp_temp == true) {
            $response = $resp_temp;
        }

        $result = $this->dao->fetchAll();
        $paginator = $result["paginator"];
        $pn = (int) $this->getEvent()->getRouteMatch()->getParam('id', 1);
        $paginator->setCurrentPageNumber($pn);
        return new ViewModel(array("response" => $response, "params" => $this->params, "entities" => $result["entities"], "paginator" => $paginator));
    }

    public function addAction() {

        $response = new \Usuarios\MisClases\Respuesta();
        
        if ($this->request->isPost()) {

            $unaEntity = new Input();
            
            $unaEntity->setNombre($this->getRequest()->getPost("nombre", null));
            $unaEntity->setLabel($this->getRequest()->getPost("label", null));
            $unaEntity->setRequired($this->getRequest()->getPost("obligatorio", null));
            $unaEntity->setTipo($this->getRequest()->getPost("tipo", null));
            $unaEntity->setEstado(1);
            $unaEntity->setOrden($this->getRequest()->getPost("orden", null));
            $unaEntity->setIdPagina($this->getRequest()->getPost("id_pagina", null));
            $unaEntity->setAyuda($this->getRequest()->getPost("ayuda", null));
            
            $input_data = $this->getRequest()->getPost("input_data", null);
            
            $unInput = null;
            
            switch ($unaEntity->getTipo()) {
                    case "texto":
                        $unInput = new \Usuarios\Model\Entity\Texto();
                        $unInput->setRespuestasRequeridas($input_data["respuestas_requeridas"]);
                        break;

                    default:
                        break;
            }
            
            $unaEntity->setControl($unInput);
            
            $response = $this->dao->save($unaEntity);
        }
        
        $view = new JsonModel(array( "response" => $response));

        $view->setTerminal(true);

        return $view;
    }

    public function editAction() {

        $response = new \Usuarios\MisClases\Respuesta();
        
        if ($this->request->isPost()) {

            $unInput = new Input();
            
            $unInput->setId($this->getRequest()->getPost("idinput", null));
            $unInput->setNombre($this->getRequest()->getPost("nombre", null));
            $unInput->setLabel($this->getRequest()->getPost("label", null));
            $unInput->setTipo($this->getRequest()->getPost("tipo", null));
            $unInput->setAyuda($this->getRequest()->getPost("ayuda", null));
            
            $input_data = $this->getRequest()->getPost("input_data", null);
            
            switch ($unInput->getTipo()) {
                    case "texto":
                        $unInputTexto = new \Usuarios\Model\Entity\Texto();
                        $unInputTexto->setRespuestasRequeridas($input_data["respuestas_requeridas"]);
                        break;

                    default:
                        break;
            }
            
            $unInput->setControl($unInputTexto);
            
            $response = $this->dao->update($unInput);
        }
        
        $view = new JsonModel(array($response));

        $view->setTerminal(true);

        return $view;
    }

    public function deleteAction() {

        $response = new \Usuarios\MisClases\Respuesta();

        if ($this->request->isGet()) {

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', null);

            if (!$id) {
                $id = $this->request->getQuery('id');
            }

            if ($id) {
                $response = $this->dao->delete($id);
            }

            $view = new JsonModel(array($response));

            $view->setTerminal(true);

            return $view;
        }
    }

    public function getInputsJsonAction() {
        
        $query = $this->request->getQuery('query');
        
        $result = $this->dao->fetchOneLike($query);

        $view = new JsonModel(array($result));

        $view->setTerminal(true);

        return $view;
    }

}
