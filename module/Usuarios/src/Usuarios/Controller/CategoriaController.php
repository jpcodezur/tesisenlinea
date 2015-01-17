<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Usuarios\Model\Entity\Categoria;

use Usuarios\Form\Categoria\CategoriaAdd;
use Usuarios\Form\Categoria\CategoriaEdit;
use Usuarios\Form\Categoria\CategoriaValidator;

class CategoriaController extends AbstractActionController {
    
    private $categoriaDao;
    
    public function __construct() {}
    
    public function setCategoriaDao($categoriaDao){
        $this->categoriaDao = $categoriaDao;
    }
    
    public function listAction() {
        $result = $this->categoriaDao->obtenerTodos();
        $paginator = $result["paginator"];
        $pn = (int) $this->getEvent()->getRouteMatch()->getParam('id',1);
        $paginator->setCurrentPageNumber($pn);
        return new ViewModel(array("categorias" => $result["categorias"], "paginator" => $paginator));
    }
    
    public function addAction() {
        
        $form = new CategoriaAdd();
        
        if ($this->request->isPost()) {
            $validator = new CategoriaValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $categoria = new Categoria();

                $nombre = $this->getRequest()->getPost('nombre-categoria', null);
                $orden = $this->getRequest()->getPost('orden-categoria', null);
                

                $categoria->setNombre($nombre);
                $categoria->setOrden($orden);
                
                $result = $this->categoriaDao->guardar($categoria);
                
                if ($result["error"] == "0") {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => true));
                } else {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => false,
                        "error" => array("mensaje" => $result["mensaje"])));
                }
            }
        }

        return new ViewModel(array("form" => $form,
            "save" => false));
    
    }
    
    public function deleteAction() {
        if ($this->request->isGet()) {

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id',null);
            if(!$id){
                $id = $this->request->getQuery('id');
            }
            
            if($id){
                $result = $this->categoriaDao->delete($id);
            }
            
            if ($result) {
                return $this->redirect()->toRoute('usuarios', array(
                            'controller' => 'categoria',
                            'action' => 'list',
                            'id'=>'1'
                ));
            }
        }
    }

}