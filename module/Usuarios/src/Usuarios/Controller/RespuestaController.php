<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Usuarios\Model\Dao\RespuestaDao;
use Usuarios\Model\Entity\Input;

class RespuestaController extends AbstractActionController {

    private $dao;

    public function __construct() {
        
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function setDao($dao){
        $this->dao = new RespuestaDao($dao);
    }

    public function IndexAction() {
        die("500");
    }

    public function addsAction() {
        
        $respuestas = $_POST;
        
        $response = $this->dao->addRespuestas($respuestas);
        
        $view = new JsonModel(array($response));

        $view->setTerminal(true);

        return $view;
        
    }
    
    public function actualizospanAction(){
        $respuestas = $_POST;
        
        $response = $this->dao->remplaceSpan($_POST);
        
        $view = new JsonModel(array($response));

        $view->setTerminal(true);

        return $view;
    }

    

}
