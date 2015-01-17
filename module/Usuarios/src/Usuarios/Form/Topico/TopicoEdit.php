<?php

namespace Usuarios\Form\Topico;

use Zend\Form\Form;
use Usuarios\Model\Dao\TopicoDao;
use Usuarios\Model\Dao\CategoriaDao;

class TopicoEdit extends Form {

    public function __construct($id_topico="",$arrayObjsTableGateway="") {

        parent::__construct();
        
        $categoriaDao = new CategoriaDao($arrayObjsTableGateway["CategoriaTableGateway"]);
        
        $topicoDao = new TopicoDao($arrayObjsTableGateway["TopicoTableGateway"]);
        
        $topico = $topicoDao->obtenerPorId($id_topico);//->getCategoria();
        
        $categoria = $topico->getCategoria();
        
        $res = $categoriaDao->obtenerTodos();
        
        $categorias = $categoriaDao->ArrayObjectToSelect($res["categorias"]);
        
        $this->add(array(
            'name' => 'id-topico',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'nombre-topico',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'puntaje-topico',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'send-topico',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-info'),
        ));

        $this->add(array(
            'name' => 'reset-topico',
            'attributes' => array(
                'type' => 'reset',
                'class' => 'btn',
                'onclick' => ''),
        ));
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'categorias-topico',
                'RegisterInArrayValidator' => false,
                'options' => array(
                        'multiple' => true, //  'Which is your mother tongue?',
                       'disable_inarray_validator' => true,
                        'value_options' => $categorias,
                ),
                'attributes' => array(
                    'value' => $categoria//set selected to 
                )
        ));
    }

}
