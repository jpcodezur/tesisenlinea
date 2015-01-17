<?php

namespace Usuarios\Form\Evaluacion;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class EvaluacionValidator extends InputFilter {

    public function __construct() {
        $this->add(
                array(
                    'name' => 'campania-evaluacion',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please select a campaign')),
                            'break_chain_on_failure' => true),
                    )
                )
        );
        
        $this->add(
                array(
                    'name' => 'campania-evaluacion',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please select a Agent')),
                            'break_chain_on_failure' => true),
                    )
                )
        );
        
    }

}