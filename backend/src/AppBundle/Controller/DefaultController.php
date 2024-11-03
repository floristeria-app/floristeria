<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
   
    public function indexAction(Request $request)
    {
		
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
	
	public function pruebasAction()
    {
		$em = $this->getDoctrine()->getManager();
		$clientes = $em->getRepository("BackendBundle:Cliente")->findAll();
//		return $clientes;
		return $this->json(var_dump($clientes));
       
    }
	
	public function homeAction(Request $request)
    {
		return $this->render('BackendBundle/Default/index.html.twig');
        //return $this->render('BackendBundle:Default:index.html.twig');
    }
	
}
