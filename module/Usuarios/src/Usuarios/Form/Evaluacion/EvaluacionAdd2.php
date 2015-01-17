<?php

namespace Usuarios\Form\Evaluacion;

use Zend\Form\Form;
use Usuarios\Model\Dao\EvaluacionDao;

class EvaluacionAdd2 extends Form {

    public function __construct($arrayObjsTableGateway = "", $campaniaDao) {

        parent::__construct();

        $this->add(array(
            'name' => 'send-evaluacion',
            'attributes' => array(
                'type' => 'button',
                'onclick' => 'javascript:document.getElementById("form-add-evaluacion").submit();',
                'class' => 'btn btn-success btn-small btn-next'),
        ));
    }

}
