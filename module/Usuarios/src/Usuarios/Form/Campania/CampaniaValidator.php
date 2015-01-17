<?php

namespace Usuarios\Form\Campania;

use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class CampaniaValidator extends InputFilter {

    public function __construct() {
        
        $this->add(
                array(
                    'name' => 'db-campaign',
                    'required' => false,
                )
        );
        
        $this->add(
                array(
                    'name' => 'aprobacion-campaign',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please enter Approval value')),
                            'break_chain_on_failure' => true),
                    )
                )
        );
        
        $this->add(
                array(
                    'name' => 'reprobacion-campaign',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StringTrim')
                    ),
                    'validators' => array(
                        array('name' => 'NotEmpty',
                            'options' => array('encoding' => 'UTF-8',
                                'messages' => array(
                                    NotEmpty::IS_EMPTY => 'Please enter Reprobation value')),
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