<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Login\Login;
use Usuarios\Form\Login\LoginValidator;
//use Usuarios\Model\Dao\IUsuarioDao;
use Usuarios\Model\Login as LoginService;
use Zend\Session\Container;
use Usuarios\Model\Entity\Usuario;
//xx
use Zend\Authentication\AuthenticationService;
use Zend\Mail;
use Usuarios\MisClases\SendEmail;

class LoginController extends AbstractActionController {

    private $config;
    private $tableGateway;
    private $auth;
    private $adapter;
    private $usuarioDao;
    private $login;

    public function __construct() {
        $this->auth = new AuthenticationService();
    }

    public function setLogin(LoginService $login) {
        $this->login = $login;
    }

    //xx
    public function setUsuarioDao($usuarioDao) {
        $this->usuarioDao = $usuarioDao;
    }

    //xx
    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    //xx
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }

    //xx
    public function getConfig($config) {
        if (!$this->config) {
            $sm = $this->getServiceLocator();
            $this->config = $config; //$sm->get('ConfigIni');
        }
        return $this->config;
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

            $usuario = $this->usuarioDao->obtenerCuenta($email, $password);

            if (!isset($miSession->usuario))
                $miSession->usuario = $usuario;

            $this->layout()->mensaje = "LoginCorrecto!!!";
            $this->layout()->colorMensaje = "green";

            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'index',
                        'action' => 'index'
            ));
        } else {
//            $mensaje = "<p style='color:red'>Datos incorrectos.</p>";
//                    $this->layout()->setTemplate('usuarios/login/login.phtml');
//                    return new ViewModel(array("mensaje" => $mensaje));

            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'login',
                        'action' => 'index'
            ));
        }
    }

    public function logoutAction() {
        $this->login->logout();
        return $this->redirect()->toRoute('usuarios', array('controller' => 'login', 'action' => 'index'));
    }

    public function registrarseAction() {
//        $usuario = $this->getServiceLocator()->get('UsuarioDao');
//        $instance->setUsuarioDao($locator->get('UsuarioDao'));
//        $usuario = UsuarioDao::getUsuario($id);
//        $form = new UsuarioAdd("UsuarioAdd", $this->tableGateway, $this->adapter);

        if ($this->request->isPost()) {

            $user = new Usuario();
            $email = $this->getRequest()->getPost('email-user', null);
            $re_email = $this->getRequest()->getPost('reemail-user', null);
            $nombre = $this->getRequest()->getPost('first-name-user', null);
            $apellido = $this->getRequest()->getPost('last-name-user', null);
            $password = $this->getRequest()->getPost('pass-user', null);
            $re_password = $this->getRequest()->getPost('pass_conf', null);
            $tipo = $this->getRequest()->getPost('level-user', null);

            if (isset($email, $re_email)) {
                if ($email !== $re_email) {
                    $mensaje = "<p style='color:red'>Error: La dirección de correo debe coincidir en ambos campos.</p>";
                    $this->layout()->setTemplate('usuarios/login/login.phtml');
                    return new ViewModel(array("mensaje" => $mensaje));
                }
            }

            if (isset($password, $re_password)) {
                if ($password !== $re_password) {
                    $mensaje = "<p style='color:red'>Error: La contraseña debe coincidir en ambos campos.</p>";
                    $this->layout()->setTemplate('usuarios/login/login.phtml');
                    return new ViewModel(array("mensaje" => $mensaje));
                }
            }

            if (!$this->noExisteEmail($email)) {
                $this->layout()->setTemplate('usuarios/login/login.phtml');
                return new ViewModel(array(
                    "save" => false,
                    "mensaje" => "<p style='color:red'>Ya existe un usuario con ese email.</p>"));
            }



            $user->setEmail($email);
            $user->setNombre($nombre);
            $user->setApellido($apellido);
            $user->setClave($password);
            $user->setTipo($tipo);
            $user->setEstado(0);
            $user->setClaveActivacion(md5($email));



            if ($this->usuarioDao->guardar($user)) {

                //Envio de link de activacion
//                $query = "UPDATE usuarios SET estado = 1 WHERE email ='" . $_POST["email-user"] . "'";
//                $current_id = $this->usuarioDao->update($user);
//                
//                if (!empty($current_id)) {
//                    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "activar.php?email=" . $user->getEmail();
//                    $toEmail = $_POST["userEmail"];
//                    $subject = "User Registration Activation Email";
//                    $content = "Clickear en el link para activar tu cuenta. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
//                    $mailHeaders = "From: Admin\r\n";
//
//                    $unEmail = new SendEmail($toEmail, "atfede@gmail.com", $subject);
//                    $unEmail->sendEmail($body);
//                    if (mail($toEmail, $subject, $content, $mailHeaders)) {
//                        $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";
//                    }
//                    unset($_POST);
//                }
                //Envio de link prueba

                $body = "click en el link para activar";
                $body .= "<a href='http://localhost/tesisenlinea/public/usuarios/login/validarclave?clave=" . $user->getClaveActivacion() . "'>Activar</a>";
                $to = $user->getEmail();
                $asunto = "Tu Tesis en Linea - Activar cuenta";

//              $unEmail = new SendEmail($to, "testcodezur@gmail.com", $asunto);
                $unEmail = new SendEmail($to, "atfede@gmail.com", $asunto);
//                $unEmail->sendEmail($body);


                $mensaje = "<p style='color:green'>Usuario creado satisfactoriamente. Verifique su email para activar su cuenta.</p>";

                /* return $this->redirect()->toRoute('usuarios', array(
                  'controller' => 'index',
                  'action' => 'index',
                  'mensaje' => $mensaje */

                $this->layout()->setTemplate('usuarios/login/login.phtml');
                return new ViewModel(array("mensaje" => $mensaje));
            } else {

                $mensaje = "<p style='color:red'>Error creando la cuenta</p>";

                $this->layout()->setTemplate('usuarios/login/login.phtml');
                return new ViewModel(array("mensaje" => $mensaje));
            }
        }


        $this->layout()->setTemplate('usuarios/login/login.phtml');
//        return new ViewModel(array("mensaje" => "Hola")); //crear nuevo View
    }

    public function noExisteEmail($pEmail) {
//        $usuario = $this->getServiceLocator()->get('UsuarioDao');
        $this->usuarioDao = $this->getServiceLocator()->get('UsuarioDao');
        $usuarios = $this->usuarioDao->obtenerTodos("all");

        $users = $usuarios["usuarios"];

        foreach ($users as $usuario) {
            $usu_email = $usuario->getEmail();
            if ($usu_email == $pEmail) {
                return 0;
            }
        }
        return 1;
    }

    public function validarclaveAction() {
        $activar = false;

        $clave = $this->getRequest()->getQuery("clave", null);
        if ($clave) {
            $activar = $this->usuarioDao->validarClave($clave);
        }

        $mensaje = "";

        if ($activar) {
            $mensaje = "<h2 style='color:green'>Usuario activado con exito</h2>";
        }

        return $this->redirect()->toRoute('usuarios', array(
                    'controller' => 'index',
                    'action' => 'index',
                    'mensaje' => $mensaje
        ));
    }

    public function recuperarpassAction() {

        $user = new Usuario();
        $email = $this->getRequest()->getPost('email-user', null);

        if ($email == "") {
            $mensaje = "<p style='color:red'></p>";
            $this->layout()->setTemplate('usuarios/login/recuperarpass.phtml');
            return new ViewModel(array("mensaje" => $mensaje));
        }

        $this->usuarioDao = $this->getServiceLocator()->get('UsuarioDao');
        $usuario = $this->usuarioDao->getUserByEmail($email);

        $randomPass = md5(date("Y-m-h h:m:s"));
        $randomPass = substr($randomPass, 0, 6);
        
        $user->setEmail($usuario["email"]);
        $user->setNombre($usuario["nombre"]);
        $user->setApellido($usuario["apellido"]);
        $user->setTipo($usuario["tipo"]);
        $user->setEstado($usuario["estado"]);
        $user->setClave($randomPass);        
        
        $body = "Su nueva contraseña es: " . $randomPass . "'";
        $to = $email;
        $asunto = "Tu Tesis en Linea - Recuperar contraseña";

        $unEmail = new SendEmail($to, "testcodezur@gmail.com", $asunto);
//        $unEmail->sendEmail($body);
        
        $this->usuarioDao->guardar($user);

        $mensaje = "<p style='color:green'>Verifique su email para recuperar su contraseña.</p>";

        $this->layout()->setTemplate('usuarios/login/recuperarpass.phtml');
        return new ViewModel(array("mensaje" => $mensaje));
    }

}
