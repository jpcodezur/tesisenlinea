<?php

namespace Usuarios\Form\Evaluacion;

use Zend\Form\Form;
use Usuarios\Model\Dao\TopicoDao;
use Usuarios\Model\Dao\CategoriaDao;

class EvaluacionEdit extends Form {

    public function __construct($evaluacion) {

        parent::__construct();

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'campania-evaluacion',
            'RegisterInArrayValidator' => false,
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => array($evaluacion->idCampania =>$evaluacion->getCampania()),
            ),
            'attributes' => array(
                'id' => 'campania-evaluacion',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'agentes-evaluacion',
            'RegisterInArrayValidator' => false,
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => array($evaluacion->idAgente =>$evaluacion->getAgente())
            ),
            'attributes' => array(
                'id' => 'agentes-evaluacion',
            )
        ));

        $this->add(array(
            'name' => 'audio-agent-evaluacion',
            'atributes' => array(
                'type' => 'text')));

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
