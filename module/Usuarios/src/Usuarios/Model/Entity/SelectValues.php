<?php

namespace Usuarios\Model\Entity;

class SelectValues{

    private $id;
    private $value;

    function getId() {
        return $this->id;
    }

    function getValue() {
        return $this->value;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setValue($value) {
        $this->value = $value;
    }


}