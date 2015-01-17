<?php

namespace Usuarios\MisClases;

class Respuesta{

    private $error = null;
    private $mensaje = "Ocurrio un Error.";
    
    public function __construct(){
        
    }
    
    function getError() {
        return $this->error;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function setError($error) {
        $this->error = $error;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }


}