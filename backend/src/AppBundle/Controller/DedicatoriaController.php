<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use BackendBundle\Entity\Dedicatoria;

class DedicatoriaController extends Controller
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
		$dedicatoria_desc = (isset($params->dedicatoria)) ? $params->dedicatoria : null;
		$motivo_cc = (isset($params->motivomotivo)) ? $params->motivomotivo : null;
		$em = $this->getDoctrine()->getManager();
		$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(
						array(
							"idmotivo" =>$motivo_cc 
						));
		
		if($nombre != null && $dedicatoria_desc != null){
			$dedicatoria = new Dedicatoria();
			$dedicatoria->setNombre($nombre);
			$dedicatoria->setDedicatoria($dedicatoria_desc);
			
			
			if (isset($motivo)) {
					$dedicatoria->setMotivomotivo($motivo);
					$em->persist($dedicatoria);
					$em->flush();
					$data["status"] = 'success';
					$data["code"] = 200;
					$data["msg"] = 'New dedicatoria created';
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "motivo not exist!!"
					);
				}
			
		}
		return $helpers->json($data);
    }
	
	public function listarAction(Request $request) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$dedicatoria_repo = $em->getRepository("BackendBundle:Dedicatoria");
		$dedicatoria = $dedicatoria_repo->findAll();
		
		$data = array(
						"status" => "success",
						"code" => 200,
						"data" => $dedicatoria
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

			$dedicatoria = $em->getRepository("BackendBundle:Dedicatoria")->findOneBy(array(
						"iddedicatoria" => $id
					));
		
			$nombre = (isset($params->nombre)) ? $params->nombre : null;
			$dedicatoria_desc = (isset($params->dedicatoria)) ? $params->dedicatoria : null;
			$motivo_id = (isset($params->motivomotivo)) ? $params->motivomotivo : null;
			
			$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(array(
						"idmotivo" => $motivo_id
					));
			
			if($nombre != null && $dedicatoria_desc != null){
				$dedicatoria->setNombre($nombre);
				$dedicatoria->setDedicatoria($dedicatoria_desc);
				$dedicatoria->setMotivomotivo($motivo);				
			
				$em->persist($dedicatoria);
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
	
	public function dedicatoriaAction(Request $request, $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$dedicatoria = $em->getRepository("BackendBundle:Dedicatoria")->findOneBy(array(
			"iddedicatoria" => $id
		));
		
		if($dedicatoria){
			$data = array();
			$data["status"] = 'success';
			$data["code"]  = 200;
			$data["data"] = $dedicatoria;
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
		$dedicatoria = $em->getRepository("BackendBundle:Dedicatoria")->findOneBy(array(
				"iddedicatoria" => $id
			));
			if (is_object($dedicatoria)) {
				$em->remove($dedicatoria);
				$em->flush();
				$data = array(
					"status" => "success",
					"code" => 200,
					"msg" => "dedicatoria deleted success"
				);
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "dedicatoria not deleted"
					);
				}		
		return $this->json($data);
	}
	
	
	public function listarPorMotivoAction(Request $request , $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$dql = "SELECT d FROM BackendBundle:Dedicatoria d "
					. "WHERE d.motivomotivo = :id ";
        $query = $em->createQuery($dql)
                    ->setParameter("id", "$id");
		$dedicatoria = $query->getResult();
				
		$data = array(
						"status" => "success",
						"code" => 200,
						"data" => $dedicatoria
					);
		
		return $helpers->json($data);
	}
}
