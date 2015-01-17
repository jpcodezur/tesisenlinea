<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Usuarios\Model\Entity\Campania;
use Usuarios\Model\Dao\CampaniaDao;
use Usuarios\Form\Campania\CampaniaEdit;
use Usuarios\Form\Campania\CampaniaAdd;
use Usuarios\Form\Campania\CampaniaValidator;

class CampaniaController extends AbstractActionController {

    private $usuarioTableGateway;
    private $campaniaTableGateway;
    private $categoriaTableGateway;
    private $topicoTableGateway;
    private $servidorTableGateway;

    public function setServidorTableGateway($sTableGateway) {
        $this->servidorTableGateway = $sTableGateway;
    }
    
    public function setUsuarioTableGateway($uTableGateway) {
        $this->usuarioTableGateway = $uTableGateway;
    }

    public function setCampaniaTableGateway($cTableGateway) {
        $this->campaniaTableGateway = $cTableGateway;
    }

    public function setTopicoTableGateway($tTableGateway) {
        $this->topicoTableGateway = $tTableGateway;
    }

    public function setCategoriaTableGateway($cTableGateway) {
        $this->categoriaTableGateway = $cTableGateway;
    }

    public function getAgentsAction() {
        $id = null;
        
        if ($this->request->isGet()) {
            $id = $this->request->getQuery('id');
        }
        
        if(!$id){
            $data = $this->request->getPost();
            $id = $this->getRequest()->getPost('id', null);
        }

        if($id){
            $campania = $this->getServiceLocator()->get('CampaniaDao');
            
            $result = $campania->getAgents($id,$this->usuarioTableGateway);

            $view = new JsonModel(array("result" => $result));

            $view->setTerminal(true);

            return $view;
        
        }
        
        return new JsonModel();
    }
    
    public function ListAction() {
        $campania = $this->getServiceLocator()->get('CampaniaDao');
        $result = $campania->fetchAll();
        $paginator = $result["paginator"];
        $pn = (int) $this->getEvent()->getRouteMatch()->getParam('id',1);
        $paginator->setCurrentPageNumber($pn);
        return new ViewModel(array("campanias" => $result["campanias"], "paginator" => $paginator));
    }

    public function addAction() {
        
        $form = new CampaniaAdd(
                    array(
                        "UsuarioTableGateway" => $this->usuarioTableGateway,
                        "CampaniaTableGateway" => $this->campaniaTableGateway,
                        "CategoriaTableGateway" => $this->categoriaTableGateway,
                        "ServidorTableGateway" => $this->servidorTableGateway,
                        "TopicoTableGateway" => $this->topicoTableGateway));
        
        /**/
        if ($this->request->isPost()) {
            $validator = new CampaniaValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $campania = new Campania();

                $nombre = $this->getRequest()->getPost('nombre-campaign', null);
                $aprobacion = $this->getRequest()->getPost('aprobacion-campaign', null);
                $reprobacion = $this->getRequest()->getPost('reprobacion-campaign', null);
                $servidor = $this->getRequest()->getPost('db-campaign', null);
                $topicos = $this->getRequest()->getPost('topics-campaign', null);

                $campania->setNombre($nombre);
                $campania->setAprobacion($aprobacion);
                $campania->setReprobacion($reprobacion);
                $campania->setServidor($servidor);
                
                $campania->setTopicos($topicos);
                $result = CampaniaDao::save($campania);
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
        
        if(!$id) {
            $id = $this->getRequest()->getPost('id-campaign', null);
        }
        
        $form = new CampaniaEdit(
                    $id, 
                    array(
                        "UsuarioTableGateway" => $this->usuarioTableGateway,
                        "CampaniaTableGateway" => $this->campaniaTableGateway,
                        "CategoriaTableGateway" => $this->categoriaTableGateway,
                        "ServidorTableGateway" => $this->servidorTableGateway,
                        "TopicoTableGateway" => $this->topicoTableGateway));
        
        if ($this->request->isGet()) {

            $campania = CampaniaDao::getCampania($id);

            return new ViewModel(array("form" => $form, "save" => false, "campania" => $campania));
        }
        
        if ($this->request->isPost()) {
            $validator = new CampaniaValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $campania = new Campania();


                $nombre = $this->getRequest()->getPost('nombre-campaign', null);
                $aprobacion = $this->getRequest()->getPost('aprobacion-campaign', null);
                $reprobacion = $this->getRequest()->getPost('reprobacion-campaign', null);
                $servidor = $this->getRequest()->getPost('db-campaign', null);
                $topicos = $this->getRequest()->getPost('topics-campaign', null);

                $campania->setId($id);
                $campania->setNombre($nombre);
                $campania->setAprobacion($aprobacion);
                $campania->setReprobacion($reprobacion);
                $campania->setServidor($servidor);
                $campania->setTopicos($topicos);
                $result = CampaniaDao::update($campania);
                if ($result["error"] == "0") {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => true,
                        "campania" => $result["campania"]));
                } else {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => false,
                        "campania" => $campania,
                        "error" => array("mensaje" => $result["mensaje"])));
                }
            }
        }

    }
    
    public function deleteAction() {
        if ($this->request->isGet()) {

            $id = $this->request->getQuery('id');
            
            $result = false;
            
            if($id){
                $campaniaDao = new CampaniaDao($this->campaniaTableGateway);
                $result = $campaniaDao->delete($id);
            }
            
            if ($result) {
                return $this->redirect()->toRoute('usuarios', array(
                            'controller' => 'campania',
                            'action' => 'list',
                            'id'=>'1'
                ));
            }
        }
    }

}