<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class PreguntaController extends AbstractActionController {

    private $dao;
    private $grupoDao;
    private $params;

    public function __construct() {
        $this->params = array(
            "table" => "preguntas",
            "join" => array(
                "alias" => array('gr' => 'grupos'),
                "on" => 'gr.id = preguntas.id_grupo',
                "alias_field" => array('Grupo' => 'titulo'),
                "type" => "", //empty = inner
                "orden"),
            "plural" => "Preguntas",
            "singular" => "Pregunta",
            "controller" => "pregunta",
            "entity" => "Usuarios\Model\Entity\Pregunta",
            "exceptions_add" => array("id_grupo"),
            "attrs" => array("id", "nombre", "titulo", "orden", "estado", "id_grupo"),
            "add_attrs" => array("nombre", "titulo", "orden", "id_grupo"),
            "edit_attrs" => array("nombre", "titulo", "orden"),
            "list_attrs" => array("nombre", "titulo", "orden",
                array("estado" => array(
                        "true" => '<span class="label label-success">%value%</span>',
                        "false" => '<span class="label label-danger">%value%</span>'))),
            "validate" => array(
                "save" => array(
                    "strExist" => array("titulo"),
                    "strlen" => array("titulo" => array(
                            "min" => "5",
                            "max" => "-1")),
                    "numeric" => array("orden")
                ),
                "edit" => array(
                    "strlen" => array("titulo" => array(
                            "min" => "5",
                            "max" => "-1")),
                    "numeric" => array("orden")
                )
            )
        );
    }

    public function setGrupoDao($paginaDao) {
        $this->grupoDao = $paginaDao;
        $this->grupoDao->setParams(array(
            "table" => "grupos",
            "join" => array(
                "alias" => array('pa' => 'paginas'),
                "on" => 'pa.id = grupos.id_pagina',
                "alias_field" => array('Pagina' => 'titulo'),
                "type" => "", //empty = inner
                "orden"),
            "plural" => "Grupos",
            "singular" => "Grupo",
            "controller" => "grupo",
            "entity" => "Usuarios\Model\Entity\Grupo",
            "exceptions_add" => array("id_pagina"),
            "attrs" => array("id", "titulo", "orden", "estado", "id_pagina"),
            "add_attrs" => array("titulo", "orden", "id_pagina"),
            "edit_attrs" => array("titulo", "orden"),
            "list_attrs" => array("titulo", "orden",
                array("estado" => array(
                        "true" => '<span class="label label-success">%value%</span>',
                        "false" => '<span class="label label-danger">%value%</span>'))),
            "validate" => array(
                "save" => array(
                    "strExist" => array("titulo"),
                    "strlen" => array("titulo" => array(
                            "min" => "5",
                            "max" => "-1")),
                    "numeric" => array("orden")
                ),
                "edit" => array(
                    "strlen" => array("titulo" => array(
                            "min" => "5",
                            "max" => "-1")),
                    "numeric" => array("orden")
                )
            )
        ));
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

        if ($resp_temp == true) {
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

        $pages = $this->grupoDao->fetchAll();

        if ($this->request->isPost()) {

            $entity = new $this->params["entity"]();

            foreach ($this->params["attrs"] as $attr) {
                $set = "set" . ucwords($attr);
                $entity->$set($this->getRequest()->getPost($attr, null));
            }

            $response = $this->dao->guardar($entity);
        }

        return new ViewModel(array("pages" => $pages["entities"], "params" => $this->params, "response" => $response));
    }

    public function editAction() {

        $response = new \Usuarios\MisClases\Respuesta();

        $pages = $this->grupoDao->fetchAll();

        if ($this->request->isGet()) {

            $id = $this->request->getQuery('id');

            $entity = $this->dao->fetchOne(array("id" => $id));

            return new ViewModel(array("pages" => $pages["entities"], "params" => $this->params, "response" => $response, "entity" => $entity));
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
                            'Usuarios\Controller\\' . $this->params["controller"], array(
                        'action' => 'list',
                        'response' => $response
            ));
        }
    }

    public function getPreguntasAction() {
        
        $query = $this->request->getQuery('query');
        
        $result = $this->dao->fetchOneLike($query);

        $view = new JsonModel(array($result));

        $view->setTerminal(true);

        return $view;
    }

}
