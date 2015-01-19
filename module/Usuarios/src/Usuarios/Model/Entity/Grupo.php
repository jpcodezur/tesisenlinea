<?php

namespace Usuarios\Model\Entity;

class Grupo {

    private $id;
    private $id_pagina;
    private $titulo;
    private $orden;
    private $estado;
    
    function getId() {
        return $this->id;
    }

    function getId_pagina() {
        return $this->id_pagina;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getOrden() {
        return $this->orden;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_pagina($id_pagina) {
        $this->id_pagina = $id_pagina;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    
}

