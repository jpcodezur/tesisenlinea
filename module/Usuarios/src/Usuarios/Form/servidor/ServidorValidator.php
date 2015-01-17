<?php

namespace Usuarios\Form\Servidor;

use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class ServidorValidator extends InputFilter {

    public function __construct() {
        $this->add(
                array(
                    'name' => 'nombre-servidor',
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
                    'name' => 'pass-servidor',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                            'messages' => array(
                             NotEmpty::IS_EMPTY => 'Please enter Password')),
                            'break_chain_on_failure' => false),
                        array(
                            'name' => 'Zend\Validator\StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 4,
                                'messages' => array(
                                    StringLength::TOO_LONG => 'Password can not be less than 3 characters.'),
                            ),
                            'break_chain_on_failure' => true
                        )
                    )
                )
        );
        
        $this->add(
                array(
                    'name' => 'repass-servidor',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please enter Retype Password')),
                            'break_chain_on_failure' => true),
                        array(
                            'name' => 'Zend\Validator\StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 4,
                                'messages' => array(
                                    StringLength::TOO_LONG => 'Retype Password can not be less than 3 characters.'),
                            ),
                            'break_chain_on_failure' => true
                        ),
                        array(
                            'name' => 'Identical',
                            'options' => array(
                                'token' => 'pass-servidor', // name of first password field
                                'messages'=>array(
                                    \Zend\Validator\Identical::NOT_SAME => "Password do not match."
                                )
                            ),
                        ),
                    )
                )
        );
        
    }

}