<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Servidor\ServidorAdd;
use Usuarios\Form\Servidor\ServidorEdit;
use Usuarios\Form\Servidor\ServidorValidator;
use Usuarios\Model\Entity\Servidor;

class ServidorController extends AbstractActionController {

    private $tableGateway;
    private $servidorDao;
    
    public function setServidorDao($dao){
        $this->servidorDao = $dao;
    }
    
    public function setTableGateway($tg){
        $this->tableGateway = $tg;
    }
    
    public function indexAction() {
        return new ViewModel();
    }

    public function listAction() {
        $result = $this->servidorDao->obtenerTodos();
        $paginator = $result["paginator"];
        $paginator->setCurrentPageNumber((int) $this->getEvent()->getRouteMatch()->getParam('id',1));
        return new ViewModel(array("servidores" => $result["servidores"], "paginator" => $paginator));
    }

    public function addAction() {


        $form = new ServidorAdd($this->tableGateway);

        if ($this->request->isPost()) {
            $validator = new ServidorValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $nombre = $this->getRequest()->getPost('nombre-servidor', null);
                $direccion = $this->getRequest()->getPost('nombre-servidor', null);
                $usuario = $this->getRequest()->getPost('usuario-servidor', null);
                $password = $this->getRequest()->getPost('pass-servidor', null);
                $db = $this->getRequest()->getPost('db-servidor', null);
                
                if(!$this->servidorDao->buscarPorNombre($nombre)){
                
                $servidor = new Servidor("", $nombre, $direccion, $usuario, $password, $db);

                $result = $this->servidorDao->guardar($servidor);
                
                }else{
                    $result["error"] = "1";
                    $result["mensaje"] = "Server already exists";
                }
                
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
            $id = $this->getRequest()->getPost('id-servidor', null);
        }

        $form = new ServidorEdit();

        if ($this->request->isGet()) {

            $servidor = $this->servidorDao->obtenerPorId($id);

            return new ViewModel(array("form" => $form, "save" => false, "servidor" => $servidor));
        }

        if ($this->request->isPost()) {
            
            $validator = new ServidorValidator();
            $form->setInputFilter($validator);
            $data = $this->request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $servidor = $this->servidorDao->obtenerPorId($id);
                
                $unServidor = new Servidor();

                $nombre = $this->getRequest()->getPost('nombre-servidor', null);
                $direccion = $this->getRequest()->getPost('nombre-servidor', null);
                $usuario = $this->getRequest()->getPost('usuario-servidor', null);
                $password = $this->getRequest()->getPost('pass-servidor', null);
                $oldpassword = $this->getRequest()->getPost('old-pass-servidor', null);
                $db = $this->getRequest()->getPost('db-servidor', null);
                
                $unServidor->setId($id);
                $unServidor->setNombre($nombre);
                $unServidor->setDireccion($direccion);
                $unServidor->setUsuario($usuario);
                $unServidor->setDb($db);
                
                if(empty($oldpassword)){
                    $result = $this->servidorDao->update($unServidor);
                }else{
                    $unServidor->setPass($password);
                    if($this->oldPassMatch($servidor->getPass(),$oldpassword)){
                        $result = $this->servidorDao->update($unServidor);

                    }else{
                        $result["error"] = "1";
                        $result["mensaje"] = "Wrong Password.";        
                    }
                }
                
                if ($result["error"] == "0") {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => true,
                        "servidor" => $result["servidor"]));
                } else {
                    return new ViewModel(array(
                        "form" => $form,
                        "save" => false,
                        "servidor" => $unServidor,
                        "error" => array("mensaje" => $result["mensaje"])));
                }
            }
        }
    }
    
    public function oldPassMatch($pass, $oldPass){
        if($pass != $oldPass){
            return false;
        }
        
        return true;
    }
    
    public function deleteAction() {
        if ($this->request->isGet()) {

            $id = $this->request->getQuery('id');
            
            $result = false;
            
            if($id){
                $result = $this->servidorDao->delete($id);
            }
            
            if ($result) {
                return $this->redirect()->toRoute('usuarios', array(
                            'controller' => 'servidor',
                            'action' => 'list',
                            'id'=>'1'
                ));
            }
        }
    }

}