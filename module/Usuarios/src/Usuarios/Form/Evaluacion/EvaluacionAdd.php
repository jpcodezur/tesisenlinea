<?php

namespace Usuarios\Form\Evaluacion;

use Zend\Form\Form;
use Usuarios\Model\Dao\EvaluacionDao;

class EvaluacionAdd extends Form {

    public function __construct($arrayObjsTableGateway = "", $campaniaDao) {

        parent::__construct();

        $resCamp = $campaniaDao->fetchAll();

        $campanias = $campaniaDao->ArrayObjectToSelect($resCamp["campanias"]);

        $campanias[0] = "-SELECT-";

        ksort($campanias);

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'campania-evaluacion',
            'RegisterInArrayValidator' => false,
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => $campanias,
            ),
            'attributes' => array(
                'onchange' => 'javascript:cargarSelectAgentes("#campania-evaluacion","#agentes-evaluacion")',
                'id' => 'campania-evaluacion',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'agentes-evaluacion',
            'RegisterInArrayValidator' => false,
            'options' => array(
                'disable_inarray_validator' => true,
            ),
            'attributes' => array(
                'id' => 'agentes-evaluacion',
            )
        ));

        $this->add(array(
            'name' => 'audio-agent-evaluacion',
            'atributes' => array(
                'type' => 'text'),
        ));

        $this->add(array(
            'name' => 'fecha-llamada',
            'atributes' => array(
                'type' => 'text'),
        ));

        $this->add(array(
            'name' => 'fecha-evaluacion',
            'atributes' => array(
                'type' => 'text'),
        ));

        $this->add(array(
            'name' => 'evaluador-evaluacion',
            'atributes' => array(
                'type' => 'text'),
        ));

        $this->add(array(
            'name' => 'send-evaluacion',
            'attributes' => array(
                'type' => 'button',
                'onclick' => 'javascript:document.getElementById("form-add-evaluacion").submit();',
                'class' => 'btn btn-success btn-small btn-next'),
        ));
    }

}
