<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use BackendBundle\Entity\Motivo;

class MotivoController extends Controller
{
   
    public function newAction(Request $request)
    {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "user not created"
		);
		
		$nombre = (isset($params->nombre)) ? $params->nombre : null;
		$descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
		
		if($nombre != null){
			$motivo = new Motivo();
			$motivo->setNombre($nombre);
			$motivo->setDescripcion($descripcion);
			
			$em = $this->getDoctrine()->getManager();
			$isset_motivo = $em->getRepository("BackendBundle:Motivo")->findBy(
						array(
							"nombre" =>$nombre 
				));
			if (count($isset_motivo) == 0) {
					$em->persist($motivo);
					$em->flush();
					$data["status"] = 'success';
					$data["code"] = 200;
					$data["msg"] = 'New motivo created';
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "motivo not created, Duplicated!!"
					);
				}
			
		}
		return $helpers->json($data);
    }
	
	public function listarAction(Request $request) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$motivo_repo = $em->getRepository("BackendBundle:Motivo");
		$motivos = $motivo_repo->findAll();
		
		$data = array(
						"status" => "success",
						"code" => 200,
						"data" => $motivos
					);
		
		return $helpers->json($data);
	}
	
	public function editarAction(Request $request, $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "Motivo no editado por defecto"
		);
		if($json != null){
			$em = $this->getDoctrine()->getManager();

			$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(array(
						"idmotivo" => $id
					));
		
			$nombre = (isset($params->nombre)) ? $params->nombre : null;
			$descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
		
			if($nombre != null && $descripcion != null){
				$motivo->setNombre($nombre);
				$motivo->setDescripcion($descripcion);
			
				$em->persist($motivo);
				$em->flush();
				$data["status"] = 'success';
				$data["code"] = 200;
				$data["msg"] = 'motivo modificado';
			}else {
				$data = array(
					"status" => "error",
					"code" => 400,
					"msg" => "motivo no editado, Motivo no encontrado"
					);
			}
		
		} else {
			$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "motivo no editado, esta vacio!!"
					);
		}
		return $helpers->json($data);
	}
	
	public function motivoAction(Request $request, $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(array(
			"idmotivo" => $id
		));
		
		if($motivo){
			$data = array();
			$data["status"] = 'success';
			$data["code"]  = 200;
			$data["data"] = $motivo;
		}else{
			$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "Motivo dont Exists"
			);
		}
		return $helpers->json($data);
	}
	
	public function removeAction(Request $request, $id = null){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(array(
				"idmotivo" => $id
			));
			if (is_object($motivo)) {
				$em->remove($motivo);
				$em->flush();
				$data = array(
					"status" => "success",
					"code" => 200,
					"msg" => "Motivo deleted success"
				);
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "Motivo not deleted"
					);
				}		
		return $helpers->json($data);
	}
	
}