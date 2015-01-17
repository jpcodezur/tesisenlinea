<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Zend\Authentication\AuthenticationService;
use Usuarios\Model\Entity\Usuario;
use Usuarios\Model\Dao\UsuarioDao;
use Usuarios\Form\Usuario\UsuarioEdit;
use Usuarios\Form\Usuario\UsuarioAdd;
use Usuarios\Form\Usuario\UsuarioValidator;

class IndexController extends AbstractActionController {

    private $config;
    private $tableGateway;
    private $usuarioDao;
    private $auth;
    private $adapter;
    private $evaluacionDao;

    public function __construct() {
        $this->auth = new AuthenticationService();
    }

    public function setEvaluacionDao($dao) {
        $this->evaluacionDao = $dao;
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function setUsuarioDao($usuarioDao) {
        $this->usuarioDao = $usuarioDao;
    }

    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }

    public function IndexAction() {

        $id = $_SESSION["miSession"]["usuario"]->getId();

        $tipo = $_SESSION["miSession"]["usuario"]->getTipo();

        $evaluationsCake = $this->DrawGraficaEvaluations($tipo,$id);
        
        $totalAgentes = $this->TotalAgentesEvaluados($tipo,"",$id);
        
        $totalAgentesPromedio = $this->TotalAgentesPromedio($tipo,$id);
        
        $topAgentes = $this->TopAgentes($tipo,$id);
        $promedioAgentes = $this->AvgAgentes($tipo,$id);
        $maxTopico = $this->getMaxMinTopico("MAX",$tipo);
        $minTopico = $this->getMaxMinTopico("MIN",$tipo);
        
        $maxCategoria = $this->getMaxMinCategoria("MAX",$tipo);
        $minCategoria = $this->getMaxMinCategoria("MIN",$tipo);
        
        $ultimasEvaluaciones = $this->getUltimasEvaluaciones($tipo,$id);
        
        return new ViewModel(array(
            "evaluationsCake" => $evaluationsCake,
            "AgentesEvaluados" => $totalAgentes,
            "totalAgentesPromedio" => $totalAgentesPromedio,
            "topAgentes" => $topAgentes,
            "promedioAgentes" => $promedioAgentes,
            "maxTopico" => $maxTopico,
            "minTopico" => $minTopico,
            "maxCategoria" => $maxCategoria,
            "minCategoria" => $minCategoria,
            
            "fechaChart" => $ultimasEvaluaciones["fechaChart"],
            "evaluacionesChart" => $ultimasEvaluaciones["evaluacionesChart"],
        ));
    }

    /**************************************************************************/
    
    public function getUltimasEvaluaciones($tipo,$id="") {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->getUltimasEvaluaciones("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->getUltimasEvaluaciones($id);
                break;
        }
        return ($res);
    }
    
    public function getMaxMinCategoria($val,$tipo) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->getMaxMinCategoria($val,"all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->getMaxMinCategoria($val,"all");
                break;
        }
        return ($res);
    }
    
    public function getMaxMinTopico($val,$tipo) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->getMaxMinTopico($val,"all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->getMaxMinTopico($val,"all");
                break;
        }
        return ($res);
    }
    
    public function TotalAgentesEvaluados($tipo,$date = "",$id) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->TotalAgentesEvaluados("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->TotalAgentesEvaluados($id);
                break;
        }
        return json_encode($res);
    }

    public function TotalAgentesPromedio($tipo,$id) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->TotalAgentesPromedio("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->TotalAgentesPromedio($id);
                break;
        }
        return json_encode($res);
    }
    
    public function TopAgentes($tipo,$id) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->TopAgentes("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->TopAgentes($id);
                break;
        }
        return json_encode($res);
    }
    
    public function AvgAgentes($tipo,$id) {
        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->AvgAgentes("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->AvgAgentes($id);
                break;
        }
        return json_encode($res);
    }

    public function TopicoMasPuntuado() {
        
    }

    public function TopicoMenosPuntuado() {
        
    }

    public function CategoriaMasPuntuada() {
        
    }

    public function CategoriaMenosPuntuada() {
        
    }

    /**************************************************************************/

    public function DrawGraficaEvaluations($tipo,$id) {

        switch ($tipo) {
            case 1:
                break;
            case 2:
                //Admin
                $res = $this->evaluacionDao->DrawGraficaEvaluations("all");
                break;
            case 3:
                break;
            case 4:
                //Agente
                $res = $this->evaluacionDao->DrawGraficaEvaluations($id);
                break;
        }

        return json_encode($res);
    }

}

