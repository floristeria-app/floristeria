<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\Pedido;


class PedidoController extends Controller
{
	public function newAction(Request $request){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "pedido not created"
		);
		
		if ($json!= null){
			$params = json_decode($json);
			
			$para = (isset($params->para)) ? $params->para : null;
			$de = (isset($params->de)) ? $params->de : null;
			$direccionEntrega = (isset($params->direccionEntrega)) ? $params->direccionEntrega : null;
			$pago = (isset($params->pago)) ? $params->pago : null;
			$valor = (isset($params->valor)) ? $params->valor : null;
			$valor_domi = (isset($params->valorDomicilio)) ? $params->valorDomicilio : null;
			$fecha_entrega = new \DateTime((isset($params->fechaEntrega)) ? $params->fechaEntrega : null);
			$fecha_cobro = new \DateTime((isset($params->fechaCobro)) ? $params->fechaCobro : null);
			$fecha_generacion = new \DateTime("now");
			$motivo_cc = (isset($params->motivomotivo)) ? $params->motivomotivo : null;
			$direccionCobro = (isset($params->direccionCobro)) ? $params->direccionCobro : null;
			$telefono_entrega = (isset($params->telefonoEntrega)) ? $params->telefonoEntrega : null;
			$telefono_cobro = (isset($params->telefonoCobro)) ? $params->telefonoCobro : null;
			$cliente_cc = (isset($params->clientecliente)) ? $params->clientecliente : null;
			$entregado = (isset($params->entregado)) ? $params->entregado : null;
			$hora = new \DateTime((isset($params->hora)) ? $params->hora : null);
			$comentario = (isset($params->comentario)) ? $params->comentario : null;
				
			if($para!= null && $de!= null){
				$em = $this->getDoctrine()->getManager();
				$cliente = $em->getRepository("BackendBundle:Cliente")->findOneBy(array(
						"idcliente" => $cliente_cc
					));
				$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(array(
						"idmotivo" => $motivo_cc
					));
				if($cliente != null && $motivo != null){
					$pedido = new Pedido();
					$pedido->setPara($para);
					$pedido->setDe($de);
					$pedido->setDireccionEntrega($direccionEntrega);
					$pedido->setPago($pago);
					$pedido->setValor($valor);
					$pedido->setValorDomicilio($valor_domi);
					$pedido->setFechaEntrega($fecha_entrega);
					$pedido->setFechaCobro($fecha_cobro);
					$pedido->setFechaGeneracion($fecha_generacion);
					$pedido->setMotivomotivo($motivo);
					$pedido->setDireccionCobro($direccionCobro);
					$pedido->setTelefonoEntrega($telefono_entrega);
					$pedido->setTelefonoCobro($telefono_cobro);
					$pedido->setClientecliente($cliente);
					$pedido->setEntregado($entregado);
					$pedido->setHora($hora);
					$pedido->setComentario($comentario);
				
					$em->persist($pedido);
					$em->flush();
				
					$data = array(
						"status" => "success",
						"code" => 200,
						"msg" => "El pedido ha sido creado"
						);
				} else {
					$data = array(
					"status" => "success",
					"code" => 500,
					"msg" => "El Cliente, motivo o dedicatoria no existe"
					);
				}
				
			} else {
				$data = array(
					"status" => "error",
					"code" => 400,
					"msg" => "El para y el de estan vacios"
					);
			}
				
		} else {
			$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "Los datos del pedido estan vacios"
				);
		}		
		
		return $helpers->json($data);
	}
	
	public function listarAction(Request $request) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT p FROM BackendBundle:Pedido p "
					. "ORDER BY p.fechaEntrega DESC";
        $query = $em->createQuery($dql);
		$pedidos = $query->getResult();
		
//		$pedido_repo = $em->getRepository("BackendBundle:Pedido");
//		$pedidos = $pedido_repo->findAll();
		$page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        
        $pagination = $paginator->paginate($pedidos, $page, $items_per_page);
        $total_items_count = $pagination->getTotalItemCount();
		
		$data = array(
            "status" => "success",
            "total_items_count" => $total_items_count,
            "page_actual" => $page,
            "items_per_page" => $items_per_page,
            "total_pages" => ceil($total_items_count / $items_per_page),
            "data" => $pagination
        );
		
		return $helpers->json($data);
	}
	
	public function pedidoAction($id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$pedido_repo = $em->getRepository("BackendBundle:Pedido");
		$pedido = $pedido_repo->findOneBy(array("idpedido"=>$id));
		$data = array(
				"status" => "success",
				"code" => 200,
				"data" => $pedido
				);
		
		return $helpers->json($data);
	}
	
	public function pagarAction(Request $request, $id){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
				
		$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "error al entrar al metodo"
				);
		
		if ($json != null){
		$params = json_decode($json);
//		$id = (isset($params->idpedido)) ? $params->idpedido : null;
		$pago = (isset($params->pago)) ? $params->pago : null;
		
		
		$em = $this->getDoctrine()->getManager();
		$pedido_repo = $em->getRepository("BackendBundle:Pedido");
		$pedido = $pedido_repo->findOneBy(array("idpedido"=>$id));
		//dump($pedido);
		if($pedido!= null){
			$pedido->setPago($pago);
			$em->persist($pedido);
			$em->flush();
			$data = array(
					"status" => "success",
					"code" => 200,
					"msg" => "el pagado ha sido actualizado"
					);
			
		} else {
			$data = array(
					"status" => "error",
					"code" => 500,
					"msg" => "El pedido no existe"
					);
		}
		
		}
		return $helpers->json($data);
	}
	
	public function entregarAction(Request $request, $id){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
				
		$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "error al entrar al metodo"
				);
		
		if ($json != null){
		$params = json_decode($json);
//		$id = (isset($params->idpedido)) ? $params->idpedido : null;
		$entregado = (isset($params->entregado)) ? $params->entregado : null;
		
		
		$em = $this->getDoctrine()->getManager();
		$pedido_repo = $em->getRepository("BackendBundle:Pedido");
		$pedido = $pedido_repo->findOneBy(array("idpedido"=>$id));
		//dump($pedido);
		if($pedido!= null){
			$pedido->setEntregado($entregado);
			$em->persist($pedido);
			$em->flush();
			$data = array(
					"status" => "success",
					"code" => 200,
					"msg" => "el entregado ha sido actualizado"
					);
			
		} else {
			$data = array(
					"status" => "error",
					"code" => 500,
					"msg" => "El pedido no existe"
					);
		}
		
		}
		return $helpers->json($data);
	}
	
	public function searchPedidoAction(Request $request, $search = null){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        
        if($search != null){
            $dql = "SELECT p FROM BackendBundle:Pedido p "
                    ." WHERE p.para LIKE :search OR "
                    . "p.de LIKE :search OR "
					."p.valor LIKE :search OR "
					."p.motivomotivo = (SELECT m FROM BackendBundle:Motivo m WHERE m.nombre LIKE :search) "
					."ORDER BY p.fechaEntrega DESC";
            $query = $em->createQuery($dql)
                    ->setParameter("search", "%$search%");
        }else{
            $dql = "SELECT p FROM BackendBundle:Pedido p ORDER BY p.idpedido DESC";
            $query = $em->createQuery($dql);
        }
 
        $page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        
        $pagination = $paginator->paginate($query, $page, $items_per_page);
        $total_items_count = $pagination->getTotalItemCount();
        
        $data = array(
            "status" => "success",
            "total_items_count" => $total_items_count,
            "page_actual" => $page,
            "items_per_page" => $items_per_page,
            "total_pages" => ceil($total_items_count / $items_per_page),
            "data" => $pagination
        );
        
        return $helpers->json($data);
    }
	
	public function clientePedidosAction(Request $request, $id = null){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        
        if($id != null){
            $dql = "SELECT p FROM BackendBundle:Pedido p "
                    . "WHERE p.clientecliente = :idcliente "
					. "ORDER BY p.fechaEntrega DESC";
            $query = $em->createQuery($dql)
                    ->setParameter("idcliente", $id);
        }else{
            $dql = "SELECT p FROM BackendBundle:Pedido p ORDER BY p.idpedido DESC";
            $query = $em->createQuery($dql);
        }
 
        $page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        
        $pagination = $paginator->paginate($query, $page, $items_per_page);
        $total_items_count = $pagination->getTotalItemCount();
        
        $data = array(
            "status" => "success",
            "total_items_count" => $total_items_count,
            "page_actual" => $page,
            "items_per_page" => $items_per_page,
            "total_pages" => ceil($total_items_count / $items_per_page),
            "data" => $pagination
        );
        
        return $helpers->json($data);
    }
	
	public function porPagarAction(Request $request){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        $dql ="SELECT p FROM BackendBundle:Pedido p WHERE p.pago = false  ORDER BY p.idpedido DESC";
		
        $query = $em->createQuery($dql);
		$pedidos = $query->getResult();
        $page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        $pagination = $paginator->paginate($pedidos, $page, $items_per_page);
        $total_items_count = $pagination->getTotalItemCount();
        
        $data = array(
            "status" => "success",
            "total_items_count" => $total_items_count,
            "page_actual" => $page,
            "items_per_page" => $items_per_page,
            "total_pages" => ceil($total_items_count / $items_per_page),
            "data" => $pagination
        );
        
        return $helpers->json($data);
    }
	
	public function porEntregarAction(Request $request){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        $dql ="SELECT p FROM BackendBundle:Pedido p WHERE p.entregado = false  ORDER BY p.idpedido DESC";
		
        $query = $em->createQuery($dql);
		$pedidos = $query->getResult();
        $page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        $pagination = $paginator->paginate($pedidos, $page, $items_per_page);
        $total_items_count = $pagination->getTotalItemCount();
        
        $data = array(
            "status" => "success",
            "total_items_count" => $total_items_count,
            "page_actual" => $page,
            "items_per_page" => $items_per_page,
            "total_pages" => ceil($total_items_count / $items_per_page),
            "data" => $pagination
        );
        
        return $helpers->json($data);
    }
	
}
