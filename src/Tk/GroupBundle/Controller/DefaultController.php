<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkGroupBundle:Default:index.html.twig');
    }

    public function switchAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$group = $em->getRepository('TkGroupBundle:TGroup')->find($id);
    	$user = $this->getUser();
    	$user->setCurrentTGroup($group);

    	$em->flush();

        $route = $this->get('request')->get('route');
        return $this->redirect($this->generateUrl($route));
    }
}
