<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Controller\Params\PaginaParams;
use Zend\View\Model\JsonModel;
use Usuarios\Model\Entity\Pagina;

class PaginaController extends AbstractActionController {

    private $dao;
    private $params;

    public function __construct() {
        $paginaParams = new PaginaParams();
        $this->params = $paginaParams->getParams();
    }

    public function setTableGateway($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function setDao($dao) {
        $this->dao = $dao;
        $this->dao->setParams($this->params);
    }

    public function IndexAction() {
        die("500");
    }

    public function ListAction() {
        $response = new \Usuarios\MisClases\Respuesta();

        $resp_temp = $this->params()->fromRoute('response');

        if ($resp_temp) {
            $response = $resp_temp;
        }

        $result = $this->dao->fetchAll();
        $paginator = $result["paginator"];
        $pn = (int) $this->getEvent()->getRouteMatch()->getParam('id', 1);
        $paginator->setCurrentPageNumber($pn);
        return new ViewModel(array("response" => $response, "params" => $this->params, "entities" => $result["entities"], "paginator" => $paginator));
    }

    public function addAction() {

        $response = new \Usuarios\MisClases\Respuesta();

        if ($this->request->isPost()) {

            $entity = new Pagina();
            
            $entity->setTitulo($this->getRequest()->getPost("nombre", null));
            $entity->setOrden($this->getRequest()->getPost("orden", null));
            $entity->setEstado(1);

            $response = $this->dao->guardar($entity);
        }
        
        $view = new JsonModel(array($response));

        $view->setTerminal(true);

        return $view;
        
    }

    public function editAction() {

        $response = new \Usuarios\MisClases\Respuesta();
        
        if ($this->request->isGet()) {
            
            $id = $this->request->getQuery('id');

            $entity = $this->dao->fetchOne(array("id" => $id));
            
            return new ViewModel(array("params" => $this->params, "response" => $response, "entity" => $entity));
        }

        if ($this->request->isPost()) {

            $id = $this->getRequest()->getPost('id', null);
            
            $entity = $this->dao->fetchOne(array("id" => $id));

            foreach ($this->params["edit_attrs"] as $attr) {
                $set = "set" . ucwords($attr);
                $entity->$set($this->getRequest()->getPost($attr, null));
            }

            $response = $this->dao->update($entity);
        }

        return new ViewModel(array("params" => $this->params, "response" => $response, "entity" => $entity));
    }

    public function deleteAction() {

        $response = new \Usuarios\MisClases\Respuesta();

        if ($this->request->isGet()) {

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', null);

            if (!$id) {
                $id = $this->request->getQuery('id');
            }

            if ($id) {
                $response = $this->dao->delete($id);
            }

            return $this->forward()->dispatch(
                            'Usuarios\Controller\\'.$this->params["controller"], array(
                        'action' => 'list',
                        'response' => $response
            ));
        }
    }

}
