<?php

namespace Usuarios\Model\Dao\Validators;

use Usuarios\Model\Dao\Validators\EditBasico;
use Usuarios\Controller\Params\InputParams;

class EditInput extends EditBasico{
    
    public function __construct($tableGateway,$dao) {
        $InputParams = new InputParams();
        $params = $InputParams->getParams();
        parent::__construct($tableGateway,$dao,$params);
    }
    
}