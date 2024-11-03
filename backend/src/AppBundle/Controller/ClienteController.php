<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\Cliente;

class ClienteController extends Controller {
	
	public function newAction(Request $request) {
		
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "user not created"
		);
		
		$numCliente = (isset($params->numCliente)) ? $params->numCliente : null;
		$nombre = (isset($params->nombre)) ? $params->nombre : null;
		$apellidos = (isset($params->apellidos)) ? $params->apellidos : null;
		$telefono = (isset($params->telefono)) ? $params->telefono : null;
		$celular = (isset($params->celular)) ? $params->celular : null;
		$email = (isset($params->email)) ? $params->email : null;
		
		$emailConstrain = new Assert\Email();
//		$emailConstrain->message = "Este email no es valido";
//		$validate_email = $this->get("validator")->validate($email, $emailConstrain);
		
		if($email != null && $nombre != null && $apellidos != null){
			$cliente = new Cliente();
			//$cliente->setIdcliente(2);
			$cliente->setNumCliente($numCliente);
			$cliente->setNombre($nombre);
			$cliente->setApellidos($apellidos);
			$cliente->setTelefono($telefono);
			$cliente->setCelular($celular);
			$cliente->setEmail($email);
			
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($cliente);
			$em->flush();
			$data["status"] = 'success';
			$data["code"] = 200;
			$data["msg"] = 'New user created';
//			$em = $this->getDoctrine()->getManager();
//			$isset_user = $em->getRepository("BackendBundle:Cliente")->findBy(
//						array(
//							"email" =>$email 
//				));
//			
//			if (count($isset_user) == 0) {
//					$em->persist($cliente);
//					$em->flush();
//					$data["status"] = 'success';
//					$data["code"] = 200;
//					$data["msg"] = 'New user created';
//				} else {
//					$data = array(
//						"status" => "error",
//						"code" => 400,
//						"msg" => "user not created, Duplicated!!"
//					);
//				}
			
		}
		return $helpers->json($data);
	}
	
	public function listClienteAction(Request $request){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$clietes_repo = $em->getRepository("BackendBundle:Cliente");
		$clientes = $clietes_repo->findAll();
		$page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 6;
        
        $pagination = $paginator->paginate($clientes, $page, $items_per_page);
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
	
	public function searchClienteAction(Request $request, $search = null){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        
        if($search != null){
            $dql = "SELECT c FROM BackendBundle:Cliente c "
                    . "WHERE c.nombre LIKE :search OR "
					."c.numCliente LIKE :search OR "
					."c.email LIKE :search OR "
					."c.celular LIKE :search OR "
					."c.telefono LIKE :search "
					. "ORDER BY c.idcliente DESC";
            $query = $em->createQuery($dql)
                    ->setParameter("search", "%$search%");
        }else{
            $dql = "SELECT c FROM BackendBundle:Cliente c ORDER BY c.idcliente DESC";
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
	
	public function editarClienteAction(Request $request, $id = null){
		
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "Cliente no editado por defecto"
		);
		if($json != null){
			$em = $this->getDoctrine()->getManager();

			$cliente = $em->getRepository("BackendBundle:Cliente")->findOneBy(array(
						"idcliente" => $id
					));
		
			$numCliente = (isset($params->numCliente)) ? $params->numCliente : null;
			$nombre = (isset($params->nombre)) ? $params->nombre : null;
			$apellidos = (isset($params->apellidos)) ? $params->apellidos : null;
			$telefono = (isset($params->telefono)) ? $params->telefono : null;
			$celular = (isset($params->celular)) ? $params->celular : null;
			$email = (isset($params->email)) ? $params->email : null;
		
			$emailConstrain = new Assert\Email();
			$emailConstrain->message = "Este email no es valido";
			$validate_email = $this->get("validator")->validate($email, $emailConstrain);
		
			if($email != null && count($validate_email) == null && $nombre != null && $apellidos != null){
				$cliente->setNumCliente($numCliente);
				$cliente->setNombre($nombre);
				$cliente->setApellidos($apellidos);
				$cliente->setTelefono($telefono);
				$cliente->setCelular($celular);
				$cliente->setEmail($email);
			
				$em->persist($cliente);
				$em->flush();
				$data["status"] = 'success';
				$data["code"] = 200;
				$data["msg"] = 'cliente modificado';
			}else {
				$data = array(
					"status" => "error",
					"code" => 400,
					"msg" => "cliente no editado, Cliente no encontrado"
					);
			}
		
		} else {
			$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "cliente no editado, esta vacio!!"
					);
		}
		return $helpers->json($data);
	}
	
	public function clienteAction(Request $request, $id = null){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$cliente = $em->getRepository("BackendBundle:Cliente")->findOneBy(array(
			"idcliente" => $id
		));
		
		if($cliente){
			$data = array();
			$data["status"] = 'success';
			$data["code"]  = 200;
			$data["data"] = $cliente;
		}else{
			$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "Video dont Exists"
			);
		}
		return $helpers->json($data);
	}
	
	public function clientePedidoAction(Request $request) {
		$helpers = $this->get("AppBundle\Services\Helpers");
        $em = $this->getDoctrine()->getManager();
        
        $clientes = $em->getRepository("BackendBundle:Cliente")->findAll();
        
		$data = array();
			$data["status"] = 'success';
			$data["code"]  = 200;
			$data["data"] = $clientes;
			
		return $helpers->json($data);
	}
}

