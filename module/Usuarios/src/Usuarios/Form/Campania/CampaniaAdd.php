<?php

namespace Usuarios\Form\Campania;

use Zend\Form\Form;
use Usuarios\Model\Dao\TopicoDao;
use Usuarios\Model\Dao\ServidorDao;

class CampaniaAdd extends Form {

    public function __construct($arrayObjsTableGateway = "") {

        parent::__construct();
        
        $servidorDao = new ServidorDao($arrayObjsTableGateway["ServidorTableGateway"]);
        
        $servidores = $servidorDao->obtenerTodos();
        
        $servidores_select = array("0"=>"Select");
        
        foreach($servidores["servidores"] as $servidor){
            $servidores_select[$servidor->getId()] = $servidor->getNombre();
        }

        $topicoDao = new TopicoDao($arrayObjsTableGateway["TopicoTableGateway"]);
        
        $result_topicos = $topicoDao->obtenerTodos();
        
        $topics = $topicoDao->ArrayObjectToSelect($result_topicos["topicos"]);
        
        $this->add(array(
            'name' => 'nombre-campaign',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'aprobacion-campaign',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'reprobacion-campaign',
            'atributes' => array(
                'type' => 'text'),
        ));
        
        $this->add(array(
            'name' => 'send-campaign',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-info'),
        ));

        $this->add(array(
            'name' => 'reset-campaign',
            'attributes' => array(
                'type' => 'reset',
                'class' => 'btn',
                'onclick' => ''),
        ));
        
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'db-campaign',
                'RegisterInArrayValidator' => false,
                'options' => array(
                        'multiple' => true, //  'Which is your mother tongue?',
                       'disable_inarray_validator' => true,
                        'value_options' => $servidores_select,
                )
        ));
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'topics-campaign',
                'RegisterInArrayValidator' => false,
                'options' => array(
                        'multiple' => true, //  'Which is your mother tongue?',
                       'disable_inarray_validator' => true,
                        'value_options' => $topics,
                )
        ));
    }

}
