<?php

namespace Usuarios\Form\Campania;

use Zend\Form\Form;
use Usuarios\Model\Dao\CampaniaDao;
use Usuarios\Model\Dao\ServidorDao;
use Usuarios\Model\Dao\TopicoDao;

class CampaniaEdit extends Form {

    public function __construct($id_campania="",$arrayObjsTableGateway="") {

        parent::__construct();
        
        $servidorDao = new ServidorDao($arrayObjsTableGateway["ServidorTableGateway"]);
        
        $servidores = $servidorDao->obtenerTodos();
        
        $servidores_select = array("0"=>"Select");
        
        foreach($servidores["servidores"] as $servidor){
            $servidores_select[$servidor->getId()] = $servidor->getNombre();
        }
        
        $campaniaDao = new CampaniaDao($arrayObjsTableGateway["CampaniaTableGateway"]);
        
        $c = $campaniaDao->getCampania($id_campania);
        
        $servidor_selected = $c->getServidor();
        
        $topicoDao = new TopicoDao($arrayObjsTableGateway["TopicoTableGateway"]);
        
        $result_topicos = $topicoDao->obtenerTodos();
        
        $topics = $topicoDao->ArrayObjectToSelect($result_topicos["topicos"]);
        
        $selected_topics = $campaniaDao->getTopicos($id_campania);
        
        $this->add(array(
            'name' => 'id-campaign',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
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
                ),
                'attributes' => array(
                    'value' => $servidor_selected//set selected to 
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
                ),
                'attributes' => array(
                    'value' => $selected_topics //set selected to 
                )
        ));
    }

}
