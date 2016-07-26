<?php

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Articulo;
use Usuarios\MisClases\Meli;

class ArticuloDao extends BaseDao implements IArticuloDao {

    private $listaCategoria;
    protected $tableGateway;
    private $adapter;

    public function __construct($tableGateway = null, $adapter = null,$config = null) {
        $this->tableGateway = $tableGateway;
        $this->adapter = $adapter;
        $this->config = $config;
    }

    public function getCategorias() {
        $articulos = array();

        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();

        $select->columns(array('categories'));
        $select->quantifier(\Zend\Db\Sql\Select::QUANTIFIER_DISTINCT);
        //echo $sql->getSqlstringForSqlObject($select); die ;
        //$select->where(array("estado"=>"1"));

        $select->order('categories ASC');

        $this->listaCategoria = $this->tableGateway->selectWith($select);

        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $sql);
        $paginator = new \Zend\Paginator\Paginator($adapter);

        foreach ($this->listaCategoria as $cat) {
            $unArticulo = new Articulo();
            $unArticulo->setCategorias($cat["categories"]);
            $articulos[] = $unArticulo;
        }

        return array("categorias" => $articulos, "paginator" => $paginator);
    }

    public function getEstados(){
        $estados = array();
        $this->adapter = $this->tableGateway->getAdapter();

        $sql = "SELECT DISTINCT * FROM estados_publicacion";

        $res = $this->adapter->query($sql);

        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $estados[] = $r;
            }
        }

        return $estados;
    }

    public function getTotalArticulos($filtros=null){
        $total = false;
        $this->adapter = $this->tableGateway->getAdapter();

        $where = "";

        if($filtros["categorias"] && $filtros["categorias"] != "todas"){
            $where = "WHERE categories='".$filtros["categorias"]."'";
        }

        if($filtros["estado"]){
            if($where){
                $where .= " AND";
            }else{
                $where .= " WHERE";
            }

            $where .= " estado='".$filtros["estado"]."'";
        }

        $sql = "SELECT COUNT(*) as total FROM articulos $where";

        $res = $this->adapter->query($sql);

        if($res){
            $result = $res->execute();
            foreach($result as $r){
                $total = $r["total"];
            }
        }

        return array("total" => $total);
    }


    public function publicarArticulo($filtros=null){
        $articulo = $this->getArticulo($filtros);
        return $this->publicarArticuloSendJson($articulo);
    }

    public function publicarArticuloSendJson($pArticulo){
		$pArticulo = $pArticulo["articulo"];
        $articulo = $this->mapeoArticulo($pArticulo);

        $params = array('access_token' => $_SESSION['access_token']);
        $meli = new Meli($this->config["secret"], $this->config["key"], $_SESSION['access_token'], $_SESSION['refresh_token']);
        $resp = $meli->post("items",$articulo,$params);
		
        $error = false;
		
        if(isset($resp["body"])){
            if(isset($resp["body"]->error)){

                //ERROR PUBLISH
                return (array(
                    "error" => $resp["body"]->error,
                    "message" => $resp["body"]->message,
                ));
            }else{
                //SUCCESS PUBLISH
                if($this->actualizarEstadoArticulo($pArticulo,$resp)){
					return (array(
						"error" => false,
						"body" => $resp["body"],
						"httpCode" => $resp["httpCode"]
					));
				}else{
					return (array(
						"error" => true,
						"body" => "",
						"httpCode" => "99"
					));
				}
            }
        }else{
            //ERROR PUBLISH (ERROR REQUEST)

            return (array(
                "error" => true,
                "body" => "",
                "httpCode" => "500"
            ));
        }

    }


    public function getArticulo($filtros){
        $this->adapter = $this->tableGateway->getAdapter();
        $where = "";

        $articulos = array();

        if($filtros["categorias"] && $filtros["categorias"] != "todas"){
            $where = "WHERE categories='".$filtros["categorias"]."'";
        }
		
        if($filtros["estado"]){
            if($where){
                $where .= " AND";
            }else{
                $where .= " WHERE";
            }

            $where .= " estado='".$filtros["estado"]."'";
        }
		
        $sql = "SELECT * FROM articulos $where ORDER BY id ASC LIMIT 1";
		
        $res = $this->adapter->query($sql);

        if($res){
            $result = $res->execute();
            foreach($result as $r){
                return array("articulo" => $r);
            }
        }

        return array("articulo" => false);
    }

    public function actualizarEstadoArticulo($articulo,$resp){
        $this->adapter = $this->tableGateway->getAdapter();
		$resp = $resp["body"];
        $sql = "UPDATE articulos SET estado='2', permalink='".$resp->date_created."', date_created='".$resp->date_created."', last_updated='".$resp->last_updated."' WHERE id='".$articulo["id"]."'";
		
        $res = $this->adapter->query($sql);
		
		if($res){
			$res->execute();
			return true;
		}
		
		return false;
    }

    public function mapeoArticulo($articulo){

        /*
            [id] => 1
            [sku] => 10000
            [_attribute_set] => Default
            [_type] => simple
            [controled] =>
            [categories] => Farmacia/CARDIOVASCULAR/
            [_root_category] => Base
            [_product_websites] => base
            [description] => AKLIS 20MG 30 COMPRIMIDOS
            [name] => AKLIS 20MG 30 COMPRIMIDOS
            [price] => 551
            [special_price] =>
            [short_description] => AKLIS 20MG 30 COMPRIMIDOS
            [status] => 1
            [tax_class_id] => 0
            [visibility] => 4
            [weight] => 1
            [image] => 10000.jpg
            [small_image] => 10000.jpg
            [thumbnail] => 10000.jpg
            [qty] => 9999
            [magmi:delete] => 0
            [estado] => 1
            [fecha_publicacion] =>
';*/
        $articulo = array(
            "title" => $articulo["name"],
            "category_id"=> "MLU1082",
            "price"=>$articulo["price"],
            "price" => $articulo["price"],
            "currency_id" => "UYU",
            "available_quantity" => $articulo["qty"],
            "buying_mode" => "buy_it_now",
            "listing_type_id" => "bronze",
            "condition" => "new",
            "description" => "Item:, <strong> ".$articulo["name"]." <\/strong> ".$articulo["short_description"],
            "video_id" => "",
            "warranty" => "",
            "pictures" => array(
                array("source" => "http://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"),
                array("source" => "http://en.wikipedia.org/wiki/File:Teashades.gif"),
            ),
        );

		return $articulo;
	}

}
