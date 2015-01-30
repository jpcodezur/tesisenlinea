<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Pagina;
use Usuarios\Model\Entity\Grupo;
use Usuarios\Model\Entity\Input;

class FormularioDao {

    private $adapter;

    public function __construct($adapter) {
        $this->adapter = $adapter;
    }

    public function getLastPage($idUsuario) {
        $sql = "select id_ultima_pagina_completa,terminado from usuario_formulario WHERE id_usuario = $idUsuario";

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                if (!$r["terminado"]) {
                    return $r["id_ultima_pagina_completa"];
                }
            }
        }

        return $this->getLastPageOrden();
    }

    public function getLastPageOrden() {

        $sql = "SELECT id FROM paginas WHERE orden = (SELECT MIN(orden) as minimo FROM `paginas` WHERE estado = 1) AND estado = 1";

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                return $r["id"];
            }
        }

        return false;
    }

    public function savePaginaCompletada($idUsuario, $idPagina, $terminado = false) {
        if ($this->getLastPage($idUsuario)) {
            $sql = "UPDATE TABLE usuario_formulario, set id_ultima_pagina_completa=$idPagina,terminado=$terminado  WHERE id_usuario = $idUsuario";
        } else {
            $sql = "INSERT INTO usuario_formulario (id_usuario,id_ultima_pagina_completa,terminado) VALUES ($idUsuario,$idPagina,$terminado";
        }

        $res = $this->adapter->query($sql);
        return $res->execute();
    }

    public function getFormulario($idPagina) {
        $sql = "SELECT * FROM inputs WHERE estado = 1 AND id_pagina = $idPagina ORDER BY orden ASC";

        $inputs = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $unInput = new Input();
                $unInput->setId($r["id"]);
                $unInput->setIdPagina($r["id_pagina"]);
                $unInput->setLabel($r["label"]);
                $unInput->setEstado($r["estado"]);
                $unInput->setOrden($r["orden"]);
                $unInput->setNombre($r["nombre"]);
                $unInput->setRequired($r["required"]);
                $unInput->setTipo($r["tipo_input"]);
                $unInput->setRespuesta($this->getRespuestaTexto($r["id"]));
                $inputs[] = $unInput;
            }
        }

        return $inputs;
    }

    public function getRespuestaTexto($idInput) {
        $sql = "SELECT rt.texto as texto from respuesta_texto as rt "
                . "INNER JOIN respuestas as r on r.id = rt.id_respuesta "
                . "WHERE r.id_input = $idInput "
                . "AND r.estado = 1";

        $results = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $rres) {
                foreach ($rres as $r) {
                    return $r;
                }
            }
        }

        return $result;
    }

    public function getPaginas() {
        $sql = "SELECT * FROM paginas WHERE estado = 1 ORDER BY orden ASC";

        $paginas = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $unaPagina = new Pagina();
                $unaPagina->setId($r["id"]);
                $unaPagina->setTitulo($r["titulo"]);
                $unaPagina->setEstado($r["estado"]);
                $unaPagina->setOrden($r["orden"]);
                $inputs = $this->getInputs($r["id"]);
                $unaPagina->setInputs($inputs);
                $paginas[] = $unaPagina;
            }
        }

        return $paginas;
    }

    public function getInputs($idPagina) {
        $sql = "SELECT * FROM inputs WHERE estado = 1 AND id_pagina = $idPagina ORDER BY orden ASC";

        $inputs = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $unInput = new Input();
                $unInput->setId($r["id"]);
                $unInput->setIdPagina($r["id_pagina"]);
                $unInput->setLabel($r["label"]);
                $unInput->setEstado($r["estado"]);
                $unInput->setOrden($r["orden"]);
                $unInput->setNombre($r["nombre"]);
                $unInput->setRequired($r["required"]);
                $unInput->setTipo($r["tipo_input"]);
                $respuesta = $this->getRespuestaTexto($r["id"]);
                $unInput->setRespuesta("");
                if (is_string($respuesta)) {
                    $unInput->setRespuesta($respuesta);
                }
                $inputs[] = $unInput;
            }
        }

        return $inputs;
    }

    public function getGruposPorPagina($idPagina, $id = null) {

        $sql = "select * from grupos WHERE estado = 1 AND id_pagina=" . $idPagina;

        if ($id) {
            $sql .= " AND id=" . $id;
        }

        $grupos = array();

        $res = $this->adapter->query($sql);
        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $unGrupo = new Grupo();
                $unGrupo->setId($r["id"]);
                $unGrupo->setTitulo($r["titulo"]);
                $unGrupo->preguntas = $this->getPreguntasPorGrupo($r["id"]);
                $grupos[] = $unGrupo;
            }
        }

        return $grupos;
    }

    public function getRespuestaJson($palabra, $idUsuario, $tipo) {
        $separadores = array("?", ".", "!", ":", ";", ",");

        $res = "";

        $respuesta = array();

        if (strpos($palabra, "@") === 0) {
            $palabra = substr($palabra, 1);
            $separador_temp = "";
            foreach ($separadores as $separador) {
                $pos = strpos($palabra, $separador);
                if ($pos !== false) {
                    $separador_temp = $separador;
                    $palabra = substr($palabra, 0, $pos);
                }
            }
            $respuesta[] = $this->getRespuestaPregunta($palabra, $idUsuario, $tipo,$separador_temp);
        }

        return $respuesta;
    }

    public function getRespuestaPregunta($nomPregunta, $idUsuario, $tipo,$separador) {

        if ($tipo == "texto") {
            $sql = "SELECT rt.texto as respuesta FROM respuesta_texto as rt "
                    . "INNER JOIN respuestas as r on r.id = rt.id_respuesta "
                    . "INNER JOIN inputs as i on i.id = r.id_input "
                    . "WHERE r.id_usuario = $idUsuario AND i.nombre = '" . $nomPregunta . "'";
        }

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $nomPregunta = $r["respuesta"];
            }
        }

        return $nomPregunta.$separador;
    }

}
