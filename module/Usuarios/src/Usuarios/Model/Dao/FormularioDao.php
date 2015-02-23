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
                $unInput->setAyuda($r["ayuda"]);
                $unInput->setRespuesta($this->getRespuestaTexto($r["id"]));

                switch ($unInput->getTipo()) {
                    case "dropdown":
                        $select = new \Usuarios\Model\Entity\Select();
                        $values = $this->getValuesSelect($unInput->getId());
                        $select->setValues($values);
                        $unInput->setControl($select);
                        break;

                    default:
                        break;
                }

                $inputs[] = $unInput;
            }
        }

        return $inputs;
    }

    public function getValuesSelect($idInput) {
        $sql = " SELECT * FROM select_collections as sc  
                INNER JOIN input_select as iss      
                on sc.id_input = iss.id_input 
                WHERE iss.id_input =  $idInput";

        $results = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $res) {
                $selectValue = new \Usuarios\Model\Entity\SelectValues();
                $selectValue->setId($res["id_select"]);
                $selectValue->setValue($res["value"]);

                $idAlumno = null;
        
                if(isset($_SESSION["miSession"]["usuario"])){
                    $idAlumno = $_SESSION["miSession"]["usuario"]->getId();
                }
                
                $idRespuesta = $this->getIdRespuesta($res["id_input"],$idAlumno);
                
                $isSelected = $this->getRespSelect($res["id_select"],$idAlumno,$idRespuesta);
                
                if ($isSelected) {
                    $selectValue->setSelected(true);
                }

                $results[] = $selectValue;
            }
        }

        return $results;
    }

    public function getIdRespuesta($idInput,$idAlumno) {
        $sql ="SELECT id FROM respuestas WHERE id_input=$idInput AND id_usuario=$idAlumno";
        
        $result = $this->adapter->query($sql)->execute();
        
        if ($result) {
            foreach ($result as $res) {
                return $res["id"];
            }
        }

        return false;
    }
    
    public function getRespSelect($id,$idAlumno,$idRespuesta) {
        
        
        //SELECT * FROM respuesta_select WHERE id_respuesta = 24 AND id_select=82 AND id_usuario=5
        // AND
        // AND id_respuesta = $idRespuesta
        $sql = "SELECT * FROM respuesta_select WHERE id_respuesta = $idRespuesta AND id_usuario=$idAlumno";
        
        $result = $this->adapter->query($sql)->execute();

        if ($result) {
            foreach ($result as $rres) {
                if ($rres["id_select"] == $id) {
                    return true;
                }
            }
        }

        return false;
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
                $unInput->setAyuda($r["ayuda"]);
                $respuesta = $this->getRespuestaTexto($r["id"]);
                $unInput->setRespuesta("");
                if (is_string($respuesta)) {
                    $unInput->setRespuesta($respuesta);
                }
                switch ($unInput->getTipo()) {
                    case "dropdown":
                        //$select = new \Usuarios\Model\Entity\Select();
                        $select = $this->getSelect($unInput->getId());
                        $values = $this->getValuesSelect($unInput->getId());
                        $select->setValues($values);
                        $unInput->setControl($select);
                        break;
                    case "texto":
                        $texto = $this->getTexto($unInput->getId());
                        $unInput->setControl($texto);
                        break;
                    default:
                        break;
                }
                $inputs[] = $unInput;
            }
        }

        return $inputs;
    }

    public function getTexto($id) {
        $input = new Input();

        $sql = "SELECT * FROM input_texto WHERE id_input=" . $id;

        $result = $this->adapter->query($sql)->execute();

        if ($result) {
            foreach ($result as $res) {
                $input->setId($res["id"]);
                $input->setRespuestasRequeridas($res["respuestas_requeridas"]);
                return $input;
            }
        }

        return $input;
    }

    public function getSelect($idInput) {

        $sql = " SELECT * FROM input_select
                WHERE id_input =  $idInput";

        $results = array();

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $res) {
                $select = new \Usuarios\Model\Entity\Select();
                $select->setId($res["id"]);
                $select->setIdInput($res["id_input"]);
                $select->setRespuestasRequeridas($res["respuestas_requeridas"]);
                $select->setTipo($res["tipo"]);

                return $select;
            }
        }

        return $results;
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

            $tipo = $this->getTipoInput($palabra);

            $respuesta[] = '<span class="resp-span" nom="' . $palabra . '" tipo="' . $tipo . '">' . $this->getRespuestaPregunta($palabra, $idUsuario, $tipo, $separador_temp) . '</span>' . $separador_temp;
        }

        return $respuesta;
    }

    public function getTipoInput($name) {
        $sql = "SELECT tipo_input FROM inputs "
                . "WHERE estado=1 AND nombre = '" . $name . "'";

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                return $r["tipo_input"];
            }
        }

        return false;
    }

    public function getRespuestaPregunta($nomPregunta, $idUsuario, $tipo, $separador) {

        if ($tipo == "texto") {
            $sql = "SELECT rt.texto as respuesta FROM respuesta_texto as rt "
                    . "INNER JOIN respuestas as r on r.id = rt.id_respuesta "
                    . "INNER JOIN inputs as i on i.id = r.id_input "
                    . "WHERE r.id_usuario = $idUsuario AND i.nombre = '" . $nomPregunta . "'";
        } elseif ($tipo == "dropdown") {
            $sql = "SELECT sc.value as respuesta FROM respuesta_select as rs "
                    . "INNER JOIN respuestas as r on r.id = rs.id_respuesta "
                    . "INNER JOIN inputs as i on i.id = r.id_input "
                    . "INNER JOIN select_collections as sc on sc.id_input = i.id AND sc.id_select = rs.id_select "
                    . "WHERE r.id_usuario = $idUsuario AND i.nombre = '" . $nomPregunta . "'";
        }

        $res = $this->adapter->query($sql);

        if ($res) {
            $result = $res->execute();
            foreach ($result as $r) {
                $nomPregunta = $r["respuesta"];
            }
        }

        return $nomPregunta;
    }

    public function dummy() {
        
    }

}
