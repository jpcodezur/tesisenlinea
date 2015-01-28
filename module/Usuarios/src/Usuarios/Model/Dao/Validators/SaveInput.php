<?php

namespace Usuarios\Model\Dao\Validators;

use Usuarios\Model\Dao\Validators\SaveBasico;
use Usuarios\Controller\Params\InputParams;

class SaveInput extends SaveBasico{
    
    public function __construct($tableGateway,$dao) {
        $InputParams = new InputParams();
        $params = $InputParams->getParams();
        parent::__construct($tableGateway,$dao,$params);
    }
    
}