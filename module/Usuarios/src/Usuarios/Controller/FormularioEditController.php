<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Usuarios\Model\Entity\Formulario;
use Usuarios\Model\Dao\FormularioEditDao;

class FormularioEditController extends AbstractActionController {
    
    protected $dao;
    
    public function setDao($dao){
        $this->dao = new FormularioEditDao($dao);
    }
    
    public function indexAction(){
        $unForm = new Formulario();
        
        $paginas = $this->dao->getPaginas();
        
        $unForm->setPaginas($paginas);
        
        return new ViewModel(array("formulario" => $unForm));
    }
    
    public function popupAction(){
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
    
}