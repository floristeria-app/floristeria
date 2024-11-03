<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use BackendBundle\Entity\ImagenTarjeta;

class ImagenTarjetaController extends Controller
{
   
    public function newAction(Request $request){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "registro not created"
		);
		
		$nombre = (isset($params->nombre)) ? $params->nombre : null;
		$descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
		$motivo_cc = (isset($params->motivomotivo)) ? $params->motivomotivo : null;
		$em = $this->getDoctrine()->getManager();
		$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(
						array(
							"idmotivo" =>$motivo_cc 
						));
		
		$file = $request->files->get("image");
		
		if($nombre != null && $descripcion != null && !empty($file)){
			$ext = $file->guessExtension();
			
			$imagenTarjeta = new ImagenTarjeta();
			$imagenTarjeta->setNombre($nombre);
			$imagenTarjeta->setDescripcion($descripcion);
			$imagenTarjeta->setMotivomotivo($motivo);
			
			if ($ext == "jpeg" || $ext == "jpg" || $ext == "png" || $ext == "gif") {
					$file_name = time() . "." . $ext;
					$file->move("uploads/tarjeta", $file_name);

					$imagenTarjeta->setUrl($file_name);
					$em->persist($imagenTarjeta);
					$em->flush();

					$data = array(
						"status" => "success",
						"code" => 200,
						"msg" => "La imagen de tarjetadel usuario fue cargada correctamente"
					);
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
		$imagenes_repo = $em->getRepository("BackendBundle:ImagenTarjeta");
		$imagenes = $imagenes_repo->findAll();
		
		$data = array(
						"status" => "success",
						"code" => 200,
						"data" => $imagenes
					);
		
		return $helpers->json($data);
	}
	
	public function imagenTarjetaAction(Request $request, $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$imagenTarjeta = $em->getRepository("BackendBundle:ImagenTarjeta")->findOneBy(array(
			"idimagenTarjeta" => $id
		));
		
		if($imagenTarjeta){
			$data = array();
			$data["status"] = 'success';
			$data["code"]  = 200;
			$data["data"] = $imagenTarjeta;
		}else{
			$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => "La imagen de la tarjeta dont Exists"
			);
		}
		return $helpers->json($data);
	}
	
	public function editarAction(Request $request, $id){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$json = $request->get("json", null);
		$params = json_decode($json);
		$data = array(
			"status" => "error",
			"code" => 400,
			"msg" => "registro not exist"
		);
		$em = $this->getDoctrine()->getManager();
		$imagenTarjeta = $em->getRepository("BackendBundle:ImagenTarjeta")->findOneBy(
						array(
							"idimagenTarjeta" =>$id
						));
		
		$nombre = (isset($params->nombre)) ? $params->nombre : null;
		$descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
		$motivo_cc = (isset($params->motivomotivo)) ? $params->motivomotivo : null;
		
		$motivo = $em->getRepository("BackendBundle:Motivo")->findOneBy(
						array(
							"idmotivo" =>$motivo_cc 
						));
		
		$file = $request->files->get("image");
		
		if($nombre != null && $descripcion != null && !empty($file)){
			$ext = $file->guessExtension();
			
			$imagenTarjeta->setNombre($nombre);
			$imagenTarjeta->setDescripcion($descripcion);
			$imagenTarjeta->setMotivomotivo($motivo);
			
			if ($ext == "jpeg" || $ext == "jpg" || $ext == "png" || $ext == "gif") {
					$file_name = time() . "." . $ext;
					$file->move("uploads/tarjeta", $file_name);

					$imagenTarjeta->setUrl($file_name);
					$em->persist($imagenTarjeta);
					$em->flush();

					$data = array(
						"status" => "success",
						"code" => 200,
						"msg" => "La imagen de tarjeta fue actualizada correctamente"
					);
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "el formato no es compatible, not exist!!"
					);
				}
			
		}
		return $helpers->json($data);
	}
	
	public function removeAction(Request $request, $id = null){
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		$imagenTarjeta = $em->getRepository("BackendBundle:ImagenTarjeta")->findOneBy(array(
				"idimagenTarjeta" => $id
			));
			if (is_object($imagenTarjeta)) {
				$em->remove($imagenTarjeta);
				$em->flush();
				$data = array(
					"status" => "success",
					"code" => 200,
					"msg" => "Imagen de tarjeta deleted success"
				);
				} else {
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => "Imagen de tarjeta not deleted"
					);
				}		
		return $this->json($data);
	}
	
	public function listarPorMotivoAction(Request $request , $id) {
		$helpers = $this->get("AppBundle\Services\Helpers");
		$em = $this->getDoctrine()->getManager();
		
		$dql = "SELECT it FROM BackendBundle:ImagenTarjeta it "
					. "WHERE it.motivomotivo = :id ";
        $query = $em->createQuery($dql)
                    ->setParameter("id", "$id");
		$imagenTarjeta = $query->getResult();
				
		$data = array(
						"status" => "success",
						"code" => 200,
						"data" => $imagenTarjeta
					);
		
		return $helpers->json($data);
	}
}
