<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Usuarios\Form\Topico\TopicoAdd;
use Usuarios\Form\Topico\TopicoEdit;
use Usuarios\Form\Topico\TopicoValidator;
use Usuarios\Model\Entity\Topico;
use Zend\View\Model\ViewModel;

class TopicoController extends AbstractActionController {

    private $topicoDao;
    private $categoriaDao;
    private $tableGateway;

    public function __construct() {}

    public function setTopicoDao($topicoDao) {
        $this->topicoDao = $topicoDao;
    }

    public function setCategoriaDao($categoriaDao) {
        $this->categoriaDao = $categoriaDao;
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function setCategoriaTableGateway($cTableGateway) {
        $this->categoriaTableGateway = $cTableGateway;
    }

    public function listAction() {
        $result = $this->topicoDao->obtenerTodos();
        $paginator = $result["paginator"];
        $paginator->setCurrentPageNumber((int) $this->getEvent()->getRouteMatch()->getParam('id',1));
        return new ViewModel(array("topicos" => $result["topicos"], "paginator" => $paginator));
    }

    public function addAction() {

        $form = new TopicoAdd($this->tableGateway, $this->categoriaDao);

        if ($this->request->isPost()) {
            $validator = new TopicoValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $topico = new Topico();

                $nombre = $this->getRequest()->getPost('nombre-topico', null);
                $puntaje = $this->getRequest()->getPost('puntaje-topico', null);
                $categoria = $this->getRequest()->getPost('categorias-topico', null);

                $topico->setNombre($nombre);
                $topico->setPuntaje($puntaje);
                $topico->setCategoria($categoria);

                $result = $this->topicoDao->guardar($topico);

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

    public function editAction() {
        $id = $this->request->getQuery('id');

        if (!$id) {
            $id = $this->getRequest()->getPost('id-topico', null);
        }

        $form = new TopicoEdit(
                $id, array(
            "CategoriaTableGateway" => $this->categoriaTableGateway,
            "TopicoTableGateway" => $this->tableGateway));

        if ($this->request->isGet()) {

            $topico = $this->topicoDao->obtenerPorId($id);
            

            return new ViewModel(array("form" => $form, "save" => false, "topico" => $topico));
        }

        if ($this->request->isPost()) {
            $validator = new TopicoValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $topico = new Topico();


                $nombre = $this->getRequest()->getPost('nombre-topico', null);
                $puntaje = $this->getRequest()->getPost('puntaje-topico', null);
                $categoria = $this->getRequest()->getPost('categorias-topico', null);
                
                $topico->setId($id);
                $topico->setNombre($nombre);
                $topico->setPuntaje($puntaje);
                $topico->setCategoria($categoria);
                
                $result = $this->topicoDao->update($topico);
                
                if ($result["error"] == "0") {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => true,
                        "topico" => $result["topico"]));
                } else {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => false,
                        "topico" => $topico,
                        "error" => array("mensaje" => $result["mensaje"])));
                }
            }
        }
    }
    
    public function deleteAction() {
        if ($this->request->isGet()) {

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id',null);
            
            if($id){
                $result = $this->topicoDao->delete($id);
            }
            
            if ($result) {
                return $this->redirect()->toRoute('usuarios', array(
                            'controller' => 'topico',
                            'action' => 'list',
                            'id'=>'1'
                ));
            }
        }
    }

}