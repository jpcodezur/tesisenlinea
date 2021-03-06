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
use Usuarios\Model\Dao\UsuarioDao;
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

    public function setUsuarioDao($usuarioDao) {
        $this->usuarioDao = $usuarioDao;
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }

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
        
        $this->layout()->mensajes = $this->flashMessenger()->getMessages();

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

            $this->flashMessenger()->addMessage("<p class='success-label mensaje-label' style='color:white;background-color:green;'>Login Correcto</p>");

            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'index',
                        'action' => 'index',
            ));
            
        } else {
            
            $this->flashMessenger()->addMessage("<p class='error-label mensaje-label' style='color:white;background-color:red'>Login Incorrecto</p>");
            
            return $this->redirect()->toRoute('usuarios', array(
                        'controller' => 'login',
                        'action' => 'index',
            ));
        }
    }

    public function logoutAction() {
        $this->login->logout();
        $this->flashMessenger()->clearCurrentMessages();
        return $this->redirect()->toRoute('usuarios', array('controller' => 'login', 'action' => 'index'));
    }

    public function registrarseAction() {
        $mensaje = "";
        
        $error = false;
        
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
                if ($email != $re_email) {
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: La dirección de correo debe coincidir en ambos campos.</p>");
                    $error = true;
                }
            }

            if (isset($password, $re_password)) {
                
                if(strlen($password) < 4){
                    $error = true;
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: El largo de la contraseña no debe ser menor a 6 caracteres.</p>");
                }
                
                if(strlen($re_password) < 4){
                    $error = true;
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: El largo de la confirmacion de la contraseña no debe ser menor a 6 caracteres.</p>");
                }
                
                if(!$password || !$re_password){
                    $error = true;
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: Debe ingresar una contraseña.</p>");
                }
                
                if ($password != $re_password) {
                    $error = true;
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: La contraseña debe coincidir en ambos campos.</p>");
                }
            }else{
                $error = true;
                $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error: Debe ingresar una contraseña.</p>");
            }

            if (!$this->noExisteEmail($email)) {
                $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Ya existe un usuario con ese email.</p>");
                $error = true;
            }

            $user->setEmail($email);
            $user->setNombre($nombre);
            $user->setApellido($apellido);
            $user->setClave($password);
            $user->setTipo($tipo);
            $user->setEstado(0);
            $user->setClaveActivacion(md5($email));
            
            if(!$error){
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
                    $body .= "<a href='http://64.22.74.53/tutesisenlinea/public/usuarios/login/validarclave?clave=" . $user->getClaveActivacion() . "'>Activar</a>";
                    $to = $user->getEmail();
                    $asunto = "Tu Tesis en Linea - Activar cuenta";

                    $unEmail = new SendEmail($to, "testcodezur@gmail.com", $asunto);
                    $unEmail->sendEmail($body);
                    $this->flashMessenger()->clearCurrentMessages();
                    $mensaje = "<p  class='success-label mensaje-label' style='color:white;background-color:green'>Usuario creado satisfactoriamente. Verifique su email para activar su cuenta.</p>";
                    $this->flashMessenger()->addMessage($mensaje);
                } else {
                    $error = true;
                    $this->flashMessenger()->clearCurrentMessages();
                    $this->flashMessenger()->addMessage("<p  class='error-label mensaje-label' style='color:white;background-color:red'>Error creando la cuenta</p>");

                }
            }
        }
        
        return $this->redirect()->toRoute('usuarios', array(
		'controller' => 'login',
		'action' => 'index',
	));
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
            $mensaje = "<h2  class='success-label mensaje-label' style='color:white;background-color:green'>Usuario activado con exito</h2>";
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
            $mensaje = "";
            $this->layout()->setTemplate('usuarios/login/recuperarpass.phtml');
            return new ViewModel(array("mensaje" => $mensaje));
        }

        $this->usuarioDao = $this->getServiceLocator()->get('UsuarioDao');
        $usuario = $this->usuarioDao->getUserByEmail($email);

        $randomPass = md5(date("Y-m-h h:m:s"));
        $randomPass = substr($randomPass, 0, 6);

        $user->setId($usuario->getId());
        $user->setEmail($usuario->getEmail());
        $user->setNombre($usuario->getNombre());
        $user->setApellido($usuario->getApellido());
        $user->setTipo($usuario->getTipo());
        $user->setEstado($usuario->getEstado());
        $user->setClave($randomPass);

        $body = "Su nueva contraseña es: " . $randomPass . "'";
        $to = $email;
        $asunto = "Tu Tesis en Linea - Recuperar contraseña";

        $unEmail = new SendEmail($to, "testcodezur@gmail.com", $asunto);
        $unEmail->sendEmail($body);

        $this->usuarioDao->updatePassword($user);

        $mensaje = "<p  class='success-label mensaje-label' style='color:white;background-color:green'>Verifique su email para recuperar su contraseña.</p>";

        $this->layout()->setTemplate('usuarios/login/recuperarpass.phtml');
        return new ViewModel(array("mensaje" => $mensaje));
    }

    public function modificarusuarioAction() {
        $user = new Usuario();
        $nom = $_POST["nom"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];

        $pass = $_POST["password"];
        $repass = $_POST["repassword"];

        $usuario = null;

        if (isset($_SESSION["miSession"]["usuario"])) {
            $usuario = $_SESSION["miSession"]["usuario"];
        }

        if ($usuario) {

            $user->setId($usuario->getId());
            if($email){
                $user->setEmail($email);
            }
            
            if($nom){
                $user->setNombre($nom);
            }
            
            if($apellido){
                $user->setApellido($apellido);
            }
            

            $user->setTipo($usuario->getTipo());
            $user->setEstado($usuario->getEstado());

            $mensaje = "Usuario modiciado satisfactoriamente";

            $status = true;

            if (strlen($pass) < 4) {
                $mensaje = "Error: La password debe ser de almenos 4 caracteres";
            } else {
                if (strlen($repass) > 0) {
                    if ($pass != $repass) {
                        $status = false;
                        $mensaje = "Passwords no coinciden";
                    } else {
                        $user->setClave(md5($pass));
                        $this->usuarioDao->updatePassword($user);
                    }
                }
            }

            if ($status) {
                $upd = $this->usuarioDao->update($user);
                if(!$upd){
                    $mensaje = "Error al actualizar";
                }
            } else {
                $mensaje = "Error al actualizar";
            }
        } else {
            $mensaje = "Error al actualizar";
        }

        return $this->redirect()->toRoute('usuarios', array(
                    'controller' => 'usuario',
                    'action' => 'profile'
        ));
    }

}
