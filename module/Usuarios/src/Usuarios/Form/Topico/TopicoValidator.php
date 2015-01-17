<?php

namespace Usuarios\Form\Topico;

use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class TopicoValidator extends InputFilter {

    public function __construct() {
        $this->add(
                array(
                    'name' => 'nombre-topico',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please enter Name')),
                            'break_chain_on_failure' => true),
                        array(
                            'name' => 'Zend\Validator\StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 3,
                                'max' => 30,
                                'messages' => array(
                                    StringLength::TOO_LONG => 'Name can not be more than 30 characters long',
                                    StringLength::TOO_SHORT => 'Name can not be less than 3 characters.')
                            ),
                            'break_chain_on_failure' => true
                        )
                    )
                )
        );
        
        $this->add(
                array(
                    'name' => 'puntaje-topico',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please enter Points')),
                            'break_chain_on_failure' => true),
                    )
                )
        );
        
        $this->add(
                array(
                    'name' => 'topics-campaign',
                    'required' => false,
                )
        );
    }

}