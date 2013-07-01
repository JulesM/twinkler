<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\WelcomeBundle\Entity\Subscribe;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TkWelcomeBundle:Default:index.html.twig');
    }

    public function registerAction()
    {
    	return $this->render('TkWelcomeBundle:Links:register.html.twig');
    }

    public function testAction()
    {
    	return $this->render('::test.html.twig');
    }

    public function subscribeAction(){

        $subscribe = new Subscribe();
        $subscribe->setDate(new \DateTime('now'));

        $form = $this->createFormBuilder($subscribe)
            ->add('email', 'email')
            ->getForm();

        $request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($subscribe);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_welcome_homepage'));
            }
        }

        return $this->render('TkWelcomeBundle:Subscribe:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
