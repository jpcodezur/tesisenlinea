<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Model\Dao\ArticuloDao;
use Zend\View\Model\JsonModel;

class ArticuloController extends AbstractActionController {

    private $articuloDao;

    public function setDao($dao){
        $this->dao = new ArticuloDao($dao);
    }

    public function setArticuloDao($articuloDao) {
        $this->articuloDao = $articuloDao;
    }

    public function indexAction(){
        $result = $this->articuloDao->getCategorias();
        return new ViewModel(array("categorias" => $result["categorias"]));
    }

    public function publicarAction(){
        $result = $this->articuloDao->getCategorias();
        return new ViewModel(array("categorias" => $result["categorias"]));
    }

    public function getTotalArticulosFilterAction(){
        $filters = $this->getRequest()->getPost("filters", null);
        $result = $this->articuloDao->getTotalArticulos($filters);
        return new JsonModel(array("total" => $result["total"]));
    }

}
