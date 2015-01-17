<?php

namespace Usuarios\Form\Servidor;

use Zend\Form\Form;

class ServidorEdit extends Form {

    public function __construct() {
        
        parent::__construct();
        
        $this->add(array(
            'name' => 'id-servidor',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'nombre-servidor',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'direccion-servidor',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'usuario-servidor',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'old-pass-servidor',
            'type' => 'Zend\Form\Element\Password'
        ));
        
        $this->add(array(
            'name' => 'pass-servidor',
            'type' => 'Zend\Form\Element\Password'
        ));
        
        $this->add(array(
            'name' => 'repass-servidor',
            'type' => 'Zend\Form\Element\Password'
        ));
        
        $this->add(array(
            'name' => 'db-servidor',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'send-servidor',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-info'),
        ));

        $this->add(array(
            'name' => 'reset-servidor',
            'attributes' => array(
                'type' => 'reset',
                'class' => 'btn',
                'onclick' => ''),
        ));
    }

}
