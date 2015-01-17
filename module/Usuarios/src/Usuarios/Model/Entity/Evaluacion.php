<?php

namespace Usuarios\Model\Entity;

class Evaluacion {

    private $id;
    private $campania;
    private $agente;
    private $urlAudio;
    private $fechaLlamada;
    private $fechaEvaluacion;
    private $evaluador;
    private $puntaje;
    private $notificado;
    private $comentario;
    private $leido;
    private $puntajeCampaniaAprobacion;
    private $puntajeCampaniaReprobacion;
    private $puntajeCampania;
    
    public function __construct($id = "", $campania = "",$id_campania = "", $agente = "",$id_agente = "", $urlAudio = "", $fechaLlamada = "", $fechaEvaluacion = "", $evaluador = "",$id_evaluador = "", $puntaje = "", $notificado = "", $comentario = "", $leido = "", $puntajeCampaniaAprobacion = "", $puntajeCampaniaReprobacion = ""){
        $this->id = $id;
        $this->campania = $campania;
        $this->idCampania = $id_campania;
        $this->agente = $agente;
        $this->idAgente = $id_agente;
        $this->urlAudio = $urlAudio;
        $this->fechaLlamada = $fechaLlamada;
        $this->fechaEvaluacion = $fechaEvaluacion;
        $this->evaluador = $evaluador;
        $this->IdEvaluador = $id_evaluador;
        $this->puntaje = $puntaje;
        $this->notificado = $notificado;
        $this->comentario = $comentario;
        $this->leido = $leido;
        $this->puntajeCampaniaAprobacion = $puntajeCampaniaAprobacion;
        $this->puntajeCampaniaReprobacion = $puntajeCampaniaReprobacion;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCampania() {
        return $this->campania;
    }

    public function getAgente() {
        return $this->agente;
    }

    public function getUrlAudio() {
        return $this->urlAudio;
    }

    public function getFechaLlamada() {
        return $this->fechaLlamada;
    }

    public function getFechaEvaluacion() {
        return $this->fechaEvaluacion;
    }

    public function getEvaluador() {
        return $this->evaluador;
    }

    public function getPuntaje() {
        return $this->puntaje;
    }

    public function getNotificado() {
        return $this->notificado;
    }

    public function getLeido() {
        return $this->leido;
    }

    public function getPuntajeCampaniaAprobacion() {
        return $this->puntajeCampaniaAprobacion;
    }

    public function getPuntajeCampaniaReprobacion() {
        return $this->puntajeCampaniaReprobacion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCampania($campania) {
        $this->campania = $campania;
    }
    
    public function setIdCampania($campania) {
        $this->campania = $campania;
    }

    public function setAgente($agente) {
        $this->agente = $agente;
    }
    
    public function setIdAgente($agente) {
        $this->agente = $agente;
    }

    public function setUrlAudio($urlAudio) {
        $this->urlAudio = $urlAudio;
    }
    
    public function setArchivo($urlAudio) {
        $this->urlAudio = $urlAudio;
    }

    public function setFechaLlamada($fechaLlamada) {
        $this->fechaLlamada = $fechaLlamada;
    }
    
    public function getPuntajeCampania(){
        return $this->puntajeCampania;
    }
    
    public function setPuntajeCampania($p){
        $this->puntajeCampania = $p;
    }

    public function setFechaEvaluacion($fechaEvaluacion) {
        $this->fechaEvaluacion = $fechaEvaluacion;
    }

    public function setEvaluador($evaluador) {
        $this->evaluador = $evaluador;
    }
    
    public function setIdSupervisor($evaluador) {
        $this->evaluador = $evaluador;
    }

    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }
    
    public function setResultado($puntaje) {
        $this->puntaje = $puntaje;
    }

    public function setNotificado($notificado) {
        $this->notificado = $notificado;
    }

    public function setLeido($leido) {
        $this->leido = $leido;
    }
    
    public function setComentarios($comentario) {
        $this->comentario = $comentario;
    }

    public function setPuntajeCampaniaAprobacion($puntajeCampaniaAprobacion) {
        $this->puntajeCampaniaAprobacion = $puntajeCampaniaAprobacion;
    }

    public function setPuntajeCampaniaReprobacion($puntajeCampaniaReprobacion) {
        $this->puntajeCampaniaReprobacion = $puntajeCampaniaReprobacion;
    }
    
    public function calcularPorcentaje($puntaje, $total) {

        if ($puntaje > 0) {

            $porcentaje = $puntaje / ($total / 100);
        } else {
            $porcentaje = 0;
        }

        return $porcentaje;
    }

}