<?php

namespace Usuarios\Model\Entity;

class Usuario {

    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $clave;
    private $avatar;
    private $tipo;
    private $campanias;
    private $idCallCenter;
    private $alertas;
    private $porcentaje = 0;

    public function __construct($id = null, $nombre = null, $apellido = null, $email = null, $clave = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function setPorcentaje($p){
        $this->porcentaje = $p;
    }
    
    public function getPorcentaje(){
        return $this->porcentaje;
    }
    
    public function setEvaluaciones($evaluaciones){
        $this->evaluaciones = $evaluaciones;
    }
    
    
    public function getEvaluaciones(){
        return $this->evaluaciones;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getIdCallCenter() {
        return $this->idCallCenter;
    }

    
    public function getAvatar(){
        return $this->avatar;
    }
    
    public function getTipo(){
        return $this->tipo;
    }
    
    public function getClave(){
        return $this->clave;
    }
    
    public function getCampanias(){
        return $this->campanias;
    }
    
    public function getAlertas(){
        return $this->alertas;
    }

    public function setNombre($param) {
        $this->nombre = $param;
    }

    public function setApellido($param) {
        $this->apellido = $param;
    }
    
    public function setIdCallCenter($param) {
        $this->idCallCenter = $param;
    }
    
    public function setTipo($param) {
        $this->tipo = $param;
    }
    
    public function setAlertas($param) {
        $this->alertas = $param;
    }

    public function setId($param) {
        $this->id = $param;
    }
    
    public function setAvatar($img){
        $this->avatar = $img;
    }
    
    public function setEmail($param){
        $this->email = $param;
    }
    
    public function setClave($param){
        $this->clave = $param;
    }
    
    public function setCampanias($param){
        $this->campanias = $param;
    }
    
}

