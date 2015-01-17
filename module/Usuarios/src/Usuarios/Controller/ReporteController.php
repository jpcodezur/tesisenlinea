<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReporteController extends AbstractActionController {
    
    private $reporteDao;
    
    public function setReporteDao($dao){
        $this->reporteDao = $dao;
    }
    
    public function setCampaniaDao($dao){
        $this->campaniaDao = $dao;
    }
    
    public function setEvaluacionDao($dao){
        $this->evaluacionDao = $dao;
    }
    
    public function setUsuarioDao($dao){
        $this->usuarioDao = $dao;
    }
    
    public function byagentsAction(){
        $usuario = "";
        
        if(isset($_SESSION["miSession"])){
            $usuario = $_SESSION["miSession"]["usuario"];
        }
        
        $fechaDesde = null;
        $fechaHasta = null;
        
        $agentes = null;
        $campanias = null;
        
        if(isset($_POST["form-field-select-agent"])){
            $agentes = $_POST["form-field-select-agent"];
        }
            
        if(isset($_POST["form-field-select-campaign"])){
            $campanias = $_POST["form-field-select-campaign"];
        }
        
        if(isset($_POST["date-range-picker"])){
            $dateRange = explode(" - ", $_POST["date-range-picker"]);
            if(($dateRange[0])){
                $fechaDesde = $dateRange[0];
                $fechaHasta = $dateRange[1];
            }
        }
        
        $result = $this->usuarioDao->obtenerTodosReportes($this->evaluacionDao,$usuario,$fechaDesde,$fechaHasta,$agentes,$campanias);
        $paginator = $result["paginator"];
        $pn = (int) $this->getEvent()->getRouteMatch()->getParam('id',1);
        $paginator->setCurrentPageNumber($pn);
        $campanias = $this->campaniaDao->fetchAll();
        $campanias = $campanias["campanias"];
        $agentes = $this->usuarioDao->obtenerTodos();
        $agentes = $agentes["usuarios"];
        return new ViewModel(array("usuarios" => $result["usuarios"], "paginator" => $paginator,"agentes"=>$agentes,"campanias"=>$campanias));
    }
    
}