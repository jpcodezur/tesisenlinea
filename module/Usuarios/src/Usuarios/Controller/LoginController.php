<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Login\Login;
use Usuarios\Form\Login\LoginValidator;
use Usuarios\Model\Dao\IUsuarioDao;
use Usuarios\Model\Login as LoginService;
use Zend\Session\Container;

class LoginController extends AbstractActionController {

    private $usuarioDao;
    
    private $login;
    
    public function setLogin(LoginService $login) {
        $this->login = $login;
    }
    
    public function setUsuarioDao(IUsuarioDao $usuarioDao) {
        $this->usuarioDao = $usuarioDao;
    }

    public function indexAction() {

        if ($this->login->isLoggedIn()) {
            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'index',
                        'action' => 'index'
            ));
        }

        $form = new Login("login");

        $modeView = new ViewModel(array("form" => $form));

        $this->layout()->setTemplate('usuarios/login/login.phtml');

        return $modeView;
    }

    public function autenticarAction() {
        
        if (!$this->request->isPost()) {
            $this->redirect()->toRoute('usuarios', array('controller' => 'login'));
        }

        $form = new Login("Login");

        $form->setInputFilter(new LoginValidator());
        $data = $this->request->getPost();

        $form->setData($data);

        if (!$form->isValid()) {
            $modeView = new ViewModel(array("form" => $form));
            $this->layout()->setTemplate('Usuarios/login/login.phtml');
            return $modeView;
        }

        $values = $form->getData();

        $email = $values["nombre"];
        $password = $values["clave"];

        $this->usuarioDao = $this->getServiceLocator()->get('UsuarioDao');

        $this->login->login($email, $password);

        if ($this->login->isLoggedIn()) {
            
            $miSession = new Container('miSession');
            
            $usuario = $this->usuarioDao->obtenerCuenta($email,$password);
            
            if(!isset($miSession->usuario))
                $miSession->usuario = $usuario;
            
            $this->layout()->mensaje = "LoginCorrecto!!!";
            $this->layout()->colorMensaje = "green";

            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'index',
                        'action' => 'index'
            ));
        } else {
            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'login',
                        'action' => 'index'
            ));
        }
    }
    
    public function logoutAction(){
        $this->login->logout();
        return $this->redirect()->toRoute('usuarios', array('controller' => 'login','action' => 'index'));
    }

}
