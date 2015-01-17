<?php

namespace Usuarios\Form\Categoria;

use Zend\Form\Form;

class CategoriaAdd extends Form {

    public function __construct($arrayObjsTableGateway = "") {

        parent::__construct();

        $this->add(array(
            'name' => 'nombre-categoria',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'orden-categoria',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'send-categoria',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-info'),
        ));

        $this->add(array(
            'name' => 'reset-categoria',
            'attributes' => array(
                'type' => 'reset',
                'class' => 'btn',
                'onclick' => ''),
        ));
        
    }

}
