<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Usuarios\Controller\Params\PaginaParams;

class FormularioController extends AbstractActionController {

    private $preguntaDao;
    private $paginaDao;
    private $paginaParams;
    private $dao;

    public function __construct() {
        $paginaParams = new PaginaParams();
        $this->paginaParams = $paginaParams->getParams();
    }

    public function setPreguntaDao($dao) {
        $this->preguntaDao = $dao;
    }
    
    public function setDao($dao) {
        $this->dao = new \Usuarios\Model\Dao\FormularioDao($dao);
    }
    
    public function setPaginaDao($dao) {
        $this->paginaDao = $dao;
        $this->paginaDao->setParams($this->paginaParams);
    }

    public function IndexAction() {
        die("500");
    }

    public function wizardAction(){
        
        $paginas = $this->dao->getPaginas();
        
        return array("paginas" => $paginas);
    }
    
    public function getSetpAction(){
        
        $idPagina = $this->request->getQuery('id_pagina');
        
        $result = $this->dao->getPaginas($idPagina);

        $view = new JsonModel(array($result));

        $view->setTerminal(true);

        return $view;
    }
    
    
    
}
