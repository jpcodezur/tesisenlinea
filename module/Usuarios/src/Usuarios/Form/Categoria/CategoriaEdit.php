<?php

namespace Usuarios\Form\Categoria;

use Zend\Form\Form;
use Usuarios\Model\Dao\CampaniaDao;
use Usuarios\Model\Dao\TopicoDao;

class CategoriaEdit extends Form {

    public function __construct($id_categoria="") {

        parent::__construct();
        
        $this->add(array(
            'name' => 'id-categoria',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
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
        
    }

}
